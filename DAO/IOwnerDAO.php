<?php 
namespace DAO;

use Models\Owner;

interface IOwnerDAO{
    function Add(Owner $owner);
    function Remove($id);
    function GetAll();
    function GetById($id);
    function GetByIdUser($idUser);
}
?>