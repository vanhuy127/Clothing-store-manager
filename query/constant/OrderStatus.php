<?php
class OrderStatus
{
    public static $INIT = 1;
    public static $PREPARING = 2;
    public static $SHIPPING = 3;
    public static $FINISH = 4;
    public static $REFUND = -1; // trả hàng
    public static $CANCEL = -2; // hủy

    public static function getStatusArray()
    {
        return [
            self::$INIT => "Được khởi tạo",
            self::$PREPARING => "Đang chuẩn bị",
            self::$SHIPPING => "Đang vận chuyển",
            self::$FINISH => "Đã hoàn thành",
            self::$REFUND => "Từ chối",
            self::$CANCEL => "Hủy",
        ];
    }

    public static function getStatusName($status)
    {
        switch ($status) {
            case self::$INIT:
                return "Được khởi tạo";
                break;
            case self::$PREPARING:
                return "Đang chuẩn bị";
                break;
            case self::$SHIPPING:
                return "Đang vận chuyển";
                break;
            case self::$FINISH:
                return "Đã hoàn thành";
                break;
            case self::$REFUND:
                return "Từ chối";
                break;
            case self::$CANCEL:
                return "Hủy";
                break;
            default:
                return "Unknown status";
                break;
        }
    }
}