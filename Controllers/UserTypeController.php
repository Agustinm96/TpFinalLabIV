<?php
    namespace Controllers;

    use DAO\UserTypeDAO;
    use Models\UserType;

    class UserTypeController
    {
        private $userTypeDAO;

        public function __construct()
        {
            $this->userTypeDAO = new UserTypeDAO();
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."add-usertype.php");
        }

        public function ShowListView()
        {
            $userTypeList = $this->userTypeDAO->GetAll();
            require_once(VIEWS_PATH."usertype-list.php");
        }

        public function Add($name, $description)
        {
            $userType = new UserType();
            $userType->setName($name);
            $userType->setDescription($description);

            $this->userTypeDAO->Add($userType);

            $this->ShowAddView();
        }

        public function Remove($id)
        {
            $this->userTypeDAO->Remove($id);

            $this->ShowListView();
        }
    }
?>