<?php
    namespace DAO;

    use Models\User;

    interface IUserDAO
    {
        function Add(User $userType);
        function getByUserName($userName);
        function GetAll();
        function GetByDNI($dni);
        function Remove($dni);
    }
?>