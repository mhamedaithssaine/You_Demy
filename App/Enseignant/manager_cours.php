 <?php
// require '../../vendor/autoload.php';

// use App\Models\Category;

// use App\Models\Tag;
// use App\Models\Cours;


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $title = $_POST['title'];
//     $description = $_POST['description'];
//     $contenu = $_POST['contenu'];
//     $contenu_video = $_POST['contenu_video'] ?? null;
//     $contenu_document = $_POST['contenu_document'] ?? null;
//     $category_id = $_POST['category_id'];
//     $scheduled_date = $_POST['scheduled_date'];

//     $cours = new Cours();

//     $cours_id = $cours->addCours([
//         'title' => $title,
//         'description' => $description,
//         'content' => $contenu === 'Document' ? $contenu_document : null,
//         'content_vedio' => $contenu === 'Video' ? $contenu_video : null,
//         'created_at' => $scheduled_date,
//         'category_id' => $category_id,
       
//     ]);

//     if ($cours_id && isset($_POST['tag_id'])) {
//         foreach ($_POST['tag_id'] as $tag_id) {
//             $cours->addTag($cours_id, $tag_id);
//         }
//     }

//     header('Location: ../../enseignat.php');
// }
?> 