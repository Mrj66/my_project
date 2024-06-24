namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('connexion.html.twig');
    }

    /**
     * @Route("/assistance", name="assistance")
     */
    public function assistance(): Response
    {
        return $this->render('assistance.html.twig');
    }
}
