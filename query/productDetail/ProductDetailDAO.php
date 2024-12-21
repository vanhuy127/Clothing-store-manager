<?php
require_once __DIR__ . '/ProductDetail.php';
class ProductDetailDAO
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function getCount($search, $category, $priceFrom, $priceTo)
    {
        $query = "  SELECT COUNT(DISTINCT p.productID) as totalProducts
                FROM products as p
                LEFT JOIN variants as v ON p.productID = v.productID
                JOIN categories as c ON p.categoryID = c.categoryID
                WHERE p.isSelling = 1
                    AND (? = '' OR p.name LIKE ?)
                    AND (? = 0 OR c.categoryID = ?)
                    AND (v.price >= ?)
                    AND (? = 0 OR v.price <= ?)";
        $stmt = $this->connection->prepare($query);

        // Xử lý các tham số đầu vào
        $searchLike = '%' . trim($search) . '%'; // Thêm ký tự % để tìm kiếm toàn phần
        $stmt->bind_param(
            'ssiiiii',
            $search,         // Tham số 1: Chuỗi tìm kiếm ban đầu
            $searchLike,     // Tham số 2: Chuỗi tìm kiếm toàn phần
            $category,       // Tham số 3: ID danh mục
            $category,       // Tham số 4: ID danh mục
            $priceFrom,      // Tham số 5: Giá thấp nhất
            $priceTo,         // Tham số 6: Giá cao nhất
            $priceTo         // Tham số 6: Giá cao nhất
        );

        $stmt->execute();
        $result = $stmt->get_result();
        $totalProducts = 0;

        if ($result && $row = $result->fetch_assoc()) {
            $totalProducts = (int)$row['totalProducts'];
        }

        return $totalProducts;
    }

    public function getAllProductDetails($search, $category, $priceFrom, $priceTo, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, i.path, i.orderNumber, 
                        c.categoryName, u.name as unitName, s.name as supplierName, v.stock, v.price, 
                        si.name as sizeName, co.name as colorName, co.colorCode
                    FROM products as p 
                    LEFT JOIN images as i ON i.productID = p.productID
                    JOIN categories as c ON p.categoryID = c.categoryID
                    JOIN units as u ON p.unitID = u.unitID
                    JOIN suppliers as s ON p.supplierID = s.supplierID
                    LEFT JOIN variants as v ON p.productID = v.productID
                    LEFT JOIN colors as co ON v.colorID = co.colorID
                    LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                    WHERE p.isSelling = 1
                        AND (? = '' OR p.name LIKE ?)
                        AND (? = 0 OR c.categoryID = ?)
                        AND (v.price >= ?)
                        AND (? = 0 OR v.price <= ?)
                    GROUP BY p.productID
                    ORDER BY i.orderNumber ASC
                    LIMIT ? OFFSET ?";

        $stmt = $this->connection->prepare($query);

        // Xử lý các tham số đầu vào
        $searchLike = '%' . trim($search) . '%'; // Thêm ký tự % để tìm kiếm toàn phần
        $stmt->bind_param(
            'ssiiiiiii',
            $search,         // Tham số 1: Chuỗi tìm kiếm ban đầu
            $searchLike,     // Tham số 2: Chuỗi tìm kiếm toàn phần
            $category,       // Tham số 3: ID danh mục
            $category,       // Tham số 4: ID danh mục
            $priceFrom,      // Tham số 5: Giá thấp nhất
            $priceTo,        // Tham số 6: Giá cao nhất
            $priceTo,        // Tham số 6: Giá cao nhất
            $pageSize,       // Tham số 7: Số sản phẩm trên mỗi trang
            $offset          // Tham số 8: Vị trí bắt đầu
        );

        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productID = $row['productID'];

                if (!isset($products[$productID])) {
                    $products[$productID] = new ProductDetail(
                        $row['productID'],
                        $row['productName'],
                        $row['description'],
                        $row['rate'],
                        $row['categoryName'],
                        $row['unitName'],
                        $row['supplierName']
                    );
                }

                if ($row['path'] && $row['orderNumber']) {
                    $products[$productID]->setImages($row['path'], $row['orderNumber']);
                }

                if ($row['stock'] !== null || $row['price'] !== null) {
                    $products[$productID]->setVariants(
                        $row['variantID'],
                        $row['stock'],
                        $row['price'],
                        $row['sizeName'],
                        $row['colorName'],
                        $row['colorCode']
                    );
                }
            }
        }

        return array_values($products);
    }

    public function getFeatureProducts($limit)
    {
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, i.path, MIN(i.orderNumber) as orderNumber, 
                        c.categoryName, u.name as unitName, s.name as supplierName, v.stock, v.price, 
                        si.name as sizeName, co.name as colorName, co.colorCode
                    FROM products as p 
                    LEFT JOIN images as i ON i.productID = p.productID
                    JOIN categories as c ON p.categoryID = c.categoryID
                    JOIN units as u ON p.unitID = u.unitID
                    JOIN suppliers as s ON p.supplierID = s.supplierID
                    LEFT JOIN variants as v ON p.productID = v.productID
                    LEFT JOIN colors as co ON v.colorID = co.colorID
                    LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                    WHERE p.isSelling = 1
                        AND (v.price >= 0)
                    GROUP BY p.productID
                    ORDER BY p.rate DESC
                    LIMIT ?";

        $stmt = $this->connection->prepare($query);

        $stmt->bind_param(
            'i',
            $limit,
        );

        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productID = $row['productID'];

                if (!isset($products[$productID])) {
                    $products[$productID] = new ProductDetail(
                        $row['productID'],
                        $row['productName'],
                        $row['description'],
                        $row['rate'],
                        $row['categoryName'],
                        $row['unitName'],
                        $row['supplierName']
                    );
                }

                if ($row['path'] && $row['orderNumber']) {
                    $products[$productID]->setImages($row['path'], $row['orderNumber']);
                }

                if ($row['stock'] !== null || $row['price'] !== null) {
                    $products[$productID]->setVariants(
                        $row['variantID'],
                        $row['stock'],
                        $row['price'],
                        $row['sizeName'],
                        $row['colorName'],
                        $row['colorCode']
                    );
                }
            }
        }

        return array_values($products);
    }

    public function getNewArrivalProducts($limit)
    {
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, p.date, i.path, MIN(i.orderNumber) as orderNumber, 
                        c.categoryName, u.name as unitName, s.name as supplierName, v.stock, v.price, 
                        si.name as sizeName, co.name as colorName, co.colorCode
                    FROM products as p 
                    LEFT JOIN images as i ON i.productID = p.productID
                    JOIN categories as c ON p.categoryID = c.categoryID
                    JOIN units as u ON p.unitID = u.unitID
                    JOIN suppliers as s ON p.supplierID = s.supplierID
                    LEFT JOIN variants as v ON p.productID = v.productID
                    LEFT JOIN colors as co ON v.colorID = co.colorID
                    LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                    WHERE p.isSelling = 1
                        AND (v.price >= 0)
                    GROUP BY p.productID
                    ORDER BY p.date DESC
                    LIMIT ?";

        $stmt = $this->connection->prepare($query);

        $stmt->bind_param(
            'i',
            $limit,
        );

        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productID = $row['productID'];

                if (!isset($products[$productID])) {
                    $products[$productID] = new ProductDetail(
                        $row['productID'],
                        $row['productName'],
                        $row['description'],
                        $row['rate'],
                        $row['categoryName'],
                        $row['unitName'],
                        $row['supplierName']
                    );
                }

                if ($row['path'] && $row['orderNumber']) {
                    $products[$productID]->setImages($row['path'], $row['orderNumber']);
                }

                if ($row['stock'] !== null || $row['price'] !== null) {
                    $products[$productID]->setVariants(
                        $row['stock'],
                        $row['variantID'],
                        $row['price'],
                        $row['sizeName'],
                        $row['colorName'],
                        $row['colorCode']
                    );
                }
            }
        }

        return array_values($products);
    }

    public function getProductByID($productID)
    {
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, i.path, i.orderNumber, 
                        c.categoryName, u.name as unitName, s.name as supplierName, v.stock, v.price, 
                        si.name as sizeName, co.name as colorName, co.colorCode
                    FROM products as p 
                    LEFT JOIN images as i ON i.productID = p.productID
                    JOIN categories as c ON p.categoryID = c.categoryID
                    JOIN units as u ON p.unitID = u.unitID
                    JOIN suppliers as s ON p.supplierID = s.supplierID
                    LEFT JOIN variants as v ON p.productID = v.productID
                    LEFT JOIN colors as co ON v.colorID = co.colorID
                    LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                    WHERE p.isSelling = 1 AND p.productID = ?
                    GROUP BY p.productID
                    ORDER BY i.orderNumber ASC";

        $stmt = $this->connection->prepare($query);

        // Bind tham số đầu vào
        $stmt->bind_param('i', $productID);

        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra xem có dữ liệu không
        if ($result && $row = $result->fetch_assoc()) {
            // Khởi tạo đối tượng ProductDetail
            $product = new ProductDetail(
                $row['productID'],
                $row['productName'],
                $row['description'],
                $row['rate'],
                $row['categoryName'],
                $row['unitName'],
                $row['supplierName']
            );

            // Thêm hình ảnh (nếu có)
            if ($row['path'] && $row['orderNumber']) {
                $product->setImages($row['path'], $row['orderNumber']);
            }

            // Thêm biến thể sản phẩm (nếu có)
            if ($row['stock'] !== null || $row['price'] !== null) {
                $product->setVariants(
                    $row['variantID'],
                    $row['stock'],
                    $row['price'],
                    $row['sizeName'],
                    $row['colorName'],
                    $row['colorCode']
                );
            }

            return $product;
        }

        // Không tìm thấy sản phẩm, trả về null
        return null;
    }

    public function getProductByIDAndVariantID($productID, $variantID)
    {
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, i.path, i.orderNumber, 
                        c.categoryName, u.name as unitName, s.name as supplierName, v.stock, v.price, 
                        si.name as sizeName, co.name as colorName, co.colorCode
                    FROM products as p 
                    LEFT JOIN images as i ON i.productID = p.productID
                    JOIN categories as c ON p.categoryID = c.categoryID
                    JOIN units as u ON p.unitID = u.unitID
                    JOIN suppliers as s ON p.supplierID = s.supplierID
                    LEFT JOIN variants as v ON p.productID = v.productID
                    LEFT JOIN colors as co ON v.colorID = co.colorID
                    LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                    WHERE p.isSelling = 1 AND p.productID = ? AND v.variantID = ?
                    GROUP BY p.productID, v.variantID
                    ORDER BY i.orderNumber ASC";

        $stmt = $this->connection->prepare($query);

        // Bind tham số đầu vào
        $stmt->bind_param('ii', $productID, $variantID);

        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra xem có dữ liệu không
        if ($result && $row = $result->fetch_assoc()) {
            // Khởi tạo đối tượng ProductDetail
            $product = new ProductDetail(
                $row['productID'],
                $row['productName'],
                $row['description'],
                $row['rate'],
                $row['categoryName'],
                $row['unitName'],
                $row['supplierName']
            );

            // Thêm hình ảnh (nếu có)
            if ($row['path'] && $row['orderNumber']) {
                $product->setImages($row['path'], $row['orderNumber']);
            }

            // Thêm biến thể sản phẩm (nếu có)
            if ($row['stock'] !== null || $row['price'] !== null) {
                $product->setVariants(
                    $row['variantID'],
                    $row['stock'],
                    $row['price'],
                    $row['sizeName'],
                    $row['colorName'],
                    $row['colorCode']
                );
            }

            return $product;
        }

        return null;
    }

    public function getProductDetailByID($productID)
    {
        $query = "  SELECT p.productID, v.variantID, p.name as productName, p.description, p.rate, 
                        i.path, i.orderNumber, c.categoryName, u.name as unitName, s.name as supplierName, 
                        v.stock, v.price, si.name as sizeName, co.name as colorName, co.colorCode
                FROM products as p 
                LEFT JOIN images as i ON i.productID = p.productID
                JOIN categories as c ON p.categoryID = c.categoryID
                JOIN units as u ON p.unitID = u.unitID
                JOIN suppliers as s ON p.supplierID = s.supplierID
                LEFT JOIN variants as v ON p.productID = v.productID
                LEFT JOIN colors as co ON v.colorID = co.colorID
                LEFT JOIN sizes as si ON v.sizeID = si.sizeID
                WHERE p.isSelling = 1 AND p.productID = ?
                ORDER BY i.orderNumber ASC";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra nếu không có kết quả trả về
        if (!$result || $result->num_rows == 0) {
            return null;
        }

        $product = null;
        $images = [];
        $variants = [];

        while ($row = $result->fetch_assoc()) {
            if (!$product) {
                // Tạo đối tượng ProductDetail lần đầu tiên
                $product = new ProductDetail(
                    $row['productID'],
                    $row['productName'],
                    $row['description'],
                    $row['rate'],
                    $row['categoryName'],
                    $row['unitName'],
                    $row['supplierName']
                );
            }

            // Xử lý và lưu trữ các hình ảnh không trùng lặp
            if ($row['path'] && $row['orderNumber']) {
                $imageKey = $row['path'] . '-' . $row['orderNumber'];
                if (!isset($images[$imageKey])) {
                    $images[$imageKey] = ['path' => $row['path'], 'orderNumber' => $row['orderNumber']];
                }
            }

            // Xử lý và lưu trữ các biến thể sản phẩm không trùng lặp
            if ($row['stock'] !== null && $row['price'] !== null) {
                $variantKey = $row['stock'] . '-' . $row['price'] . '-' . $row['sizeName'] . '-' . $row['colorName'];
                if (!isset($variants[$variantKey])) {
                    $variants[$variantKey] = [
                        'id' => $row['variantID'],
                        'stock' => $row['stock'],
                        'price' => $row['price'],
                        'sizeName' => $row['sizeName'],
                        'colorName' => $row['colorName'],
                        'colorCode' => $row['colorCode']
                    ];
                }
            }
        }

        // Gán hình ảnh vào đối tượng sản phẩm
        foreach ($images as $image) {
            $product->setImages($image['path'], $image['orderNumber']);
        }

        // Gán các biến thể vào đối tượng sản phẩm
        foreach ($variants as $variant) {
            $product->setVariants(
                $variant['id'],
                $variant['stock'],
                $variant['price'],
                $variant['sizeName'],
                $variant['colorName'],
                $variant['colorCode']
            );
        }

        return $product;
    }
}
