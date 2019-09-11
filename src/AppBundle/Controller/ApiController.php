<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Doctrine\DBAL\Query\QueryBuilder;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



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
     * @Route("/category/get", name="get_category", methods={"GET"})
     *
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

    /**
     * @Route("/product/post", name="add_product", methods={"POST"})
     * @param Request $request
     * @return View
     */
    public function addProductAction(Request $request)
    {

        $product = new Product;
        $name = $request->get('name');
        $price = $request->get('price');
        $description = $request->get('description');
        $category = $request->get('category');
        if (empty($description) ||empty($name) || (empty($price)) ) {
            return new View("Error", Response::HTTP_NOT_ACCEPTABLE);
        }

        $product->setName($name);
        $product->setPrice($price);
        $product->setDescription($description);
        $product->setCategory($category);
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return new View("Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Route("/product/get" , name="get_product", methods={"GET"})
     *
     */
    public function getProductAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var QueryBuilder $queryBuilder */
        $res = $em->getRepository(Product::class)->getAllProducts() ;

        $arr = array_column($res, 'price');


        return new JsonResponse($res,200);

    }

    /**
     * @Route("/product/delete/{id}", name="delete_product", methods={"DELETE"})

     */
    public function deleteAction($id)
    {
        $data = new Product();
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        if(empty($product))
        {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        }
        else{
            $em->remove($product);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Route("/product/update/{id}", name="put_product", methods={"PUT"})

     * @param Request $request
     * @param $id
     * @return View
     */
    public function updateAction( Request $request, $id)
    {
        $data =  new Product();
        $id = $request->get('id');
        $name = $request->get('name');
        $price = $request->get('price');
        $description = $request->get('description');
        $category = $request->get('category');

        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        if(empty($product))
        {
            return new View("product not found", Response::HTTP_NOT_FOUND);
        }
        if(!empty($id) && !empty($category) && !empty($name) && !empty($price) && !empty($description))
        {
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->
            $em->flush();
            return new View("Product updated successfully", Response::HTTP_OK);
        }
        else return new View("Product cannot be empty", Response::HTTP_NOT_ACCEPTABLE);


    }





}
