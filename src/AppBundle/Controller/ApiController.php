<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Doctrine\DBAL\Query\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiController
 * @package AppBundle\Controller
 * @Route("/api")
 */
class ApiController extends Controller
{

    /**
     * Lists all Category entities.
     *
     * @Route("/category/", name="get_category")
     * @Method("GET")
     */
    public function getCategoryAction()
    {

        $category = [

        ];



        $em = $this->getDoctrine()->getManager();
        /** @var QueryBuilder $queryBuilder */
         $queryBuilder = $em->getRepository('AppBundle:Category')->createQueryBuilder('e')->getQuery() ;
        $res = $queryBuilder->getResult();

        /** @var Category $ala */
        foreach ($res as $ala) {
            $category[]=$ala->getName();
        }




       return new JsonResponse($category,200);
    }
}