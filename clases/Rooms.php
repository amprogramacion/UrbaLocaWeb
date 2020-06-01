<?php

class Rooms extends Web {

    public static function GetRooms() {
        $sql = "SELECT * FROM rooms";
        $query = self::query($sql);
        if (self::rowCount($query) >= 1) {
            return self::fetchAll($query);
        }
    }

}
