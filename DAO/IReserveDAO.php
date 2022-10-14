<?php 
namespace DAO;

use Models\Reserve;

interface IReserveDAO{
    function Add(Reserve $reserve);
    function Remove($id);
    function GetAll();
}
?>