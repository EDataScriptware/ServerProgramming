<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4 - PhoneNumbers.class.php -->
<?php
class PhoneNumbers { 
    private $PersonID;
    private $PhoneType;
    private $PhoneNum;
    private $AreaCode;

    public function getID() {
        return $this->PersonID;
    }

    public function getPhoneType() {
        return $this->PhoneType;
    }

    public function getPhoneNum() {
        return $this->PhoneNum;
    }

    public function getAreaCode() {
        return $this->AreaCode;
    }
}
?>