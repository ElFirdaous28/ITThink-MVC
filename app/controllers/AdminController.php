<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Project.php');
require_once(__DIR__ . '/../models/Testimonials.php');

class AdminController extends BaseController
{
   private $UserModel;
   private $ProjectModel;
   private $TestimonialModel;
   public function __construct()
   {
      $this->UserModel = new User();
      $this->ProjectModel = new Project();
      $this->TestimonialModel = new Testimonials();
   }

   public function index()
   {

      if (!isset($_SESSION['user_loged_in_id'])) {
         header("Location: /login ");
         exit;
      }
      $statistics =  $this->UserModel->getStatistics();
      $this->renderDashboard('admin/index', ["statistics" => $statistics]);
   }

   public function categories()
   {

      $this->renderDashboard('admin/categories');
   }
   // =========================================================== users methods ===========================================
   public function handleUsers()
   {
      // Get filter and search values from GET
      $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // Default to 'all' if no filter is selected
      $userToSearch = isset($_GET['userToSearch']) ? $_GET['userToSearch'] : ''; // Default to empty if no search term is provided

      // Call showUsers with both filter and search term
      $users = $this->UserModel->getAllUsers($filter, $userToSearch);
      $this->renderDashboard('admin/users', ["users" => $users]);
   }

   public function changeUserStatus()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['block_user_id'])) {
         $idUser = $_POST['block_user_id'];
         $this->UserModel->changeUserStatus($idUser);
         header("Location: /admin/users");
         exit();
      }
   }

   public function removeUser()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_user'])) {
         $idUser = $_POST['remove_user'];
         $this->UserModel->removeUser($idUser);
         header("Location: /admin/users");
         exit();
      }
   }

   // =========================================================== projects methods ===========================================
   // show all projects
   public function Allprojects()
   {
      $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
      $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
      $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
      $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';

      $projects = $this->ProjectModel->allProjects($filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch);

      $this->renderDashboard('admin/projects', ["projects" => $projects]);
   }
   // delete a project
   public function removeProject()
   {
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_project'])) {
         $idProject = $_POST['id_projet'];
         $this->ProjectModel->removeProject($idProject);
         header("Location: /admin/projects");
         exit();
      }
   }

   // =========================================================== testimonials methods ===========================================
   // show all testimonials
   public function testimonials()
   {
      $testimonials = $this->TestimonialModel->allTestimonials();
      $this->renderDashboard('admin/testimonials', ["testimonials" => $testimonials]);
   }
   
   // remove testimonial
   public function removeTestimonial(){
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_testimonial'])) {
         $idtesTimonial = $_POST['id_temoignage'];
         $this->TestimonialModel->removeTestimonial($idtesTimonial);
         header("Location: /admin/testimonials");
         exit();
     }
   }
}
