<?php
    namespace DAO;

    use Models\User;

    interface IUserDAO
    {
        function Add(User $userType);
        function getByUserName($userName);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }
?>