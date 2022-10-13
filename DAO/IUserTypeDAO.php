<?php
    namespace DAO;

    use Models\UserType;

    interface IUserTypeDAO
    {
        function Add(UserType $beerType);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }
?>