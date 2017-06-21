<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Excel2007;
use PhpOffice\PhpSpreadsheet\Style;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use PhpOffice\PhpSpreadsheet\Writer\PDF\MPDF;

/**
* @Route("/product")
*/
class ProductController extends Controller
{
    /**
     * @Route("/", name="listproduct")
     */
    public function listAction(Request $request)

    {
        /*$pdf = new \mPDF();
        $pdf->WriteHTML('<h1>Hello world!</h1>');
        $pdf->Output();*/

        $products = $this->get('app.repository.product')
            ->getQueryBuilderForAll($request->query->get('search'))
            ->getQuery();
        /*$products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->getQueryBuilderForAll($request->query->get('search'));*/

        $products->setHydrationMode(Query::HYDRATE_ARRAY);

        $pagination = $this->get('knp_paginator')->paginate(
            $products,
            $request->query->getInt('page', 1),
            Product::NUM_ITEMS
        );

        return $this->render('products/index.html.twig',array('pagination'=>$pagination));
    }

    public function holaAction()
    {

    }

    /**
     * @Route("/new/", name="newproduct")
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //Cargar y mover la imagen
            $this->loadFile($product);

            $this->get('app.repository.product')->save($product);

            $this->addFlash('success', sprintf(
                'El producto con el código %s se ha creado con éxito!',
                $product->getCode()
            ));

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/new.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}/", name="editproduct")
     */
    public function editAction(Request $request, Product $product)
    {
        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Cargar y mover la imagen
            $this->loadFile($product);

            $this->get('app.repository.product')->save($product);

            $this->addFlash('success', sprintf(
                'El producto con el código %s se ha actualizado con éxito!',
                $product->getCode()
            ));

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/edit.html.twig', array(
            'form'=>$form->createView(),
            'product'=>$product
        ));
    }

    /**
     * @Route("/delete/{id}/", name="deleteproduct")
     */
    public function deleteAction(Product $product)
    {
        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $this->get('app.repository.product')->delete($product);

        $this->addFlash('success', sprintf(
            'El producto con el código %s se ha eliminado con éxito!',
            $product->getCode()
        ));

        return $this->redirectToRoute('listproduct');
    }

    public function loadFile(Product $product){
        // La variable $file guardará el PDF subido
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $product->getImg();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Mover el archivo al directorio donde se guardan los curriculums
        $cvDir = $this->container->getparameter('kernel.root_dir').'/../web/uploads/product';
        $file->move($cvDir, $fileName);

        //Actualizar la propiedad de la imagen
        $product->setImg($fileName);
    }

    /**
     * @Route("/export/", name="exportProducts")
     */
    public function exportAction(){
        $products = $this->get('app.repository.product')->findAll();

        //Styles
        $titleStyle   = array(
            'alignment' => array(
                'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
                'wrap' => true
            ),
            'fill' => array(
                'type' => Style\Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '03254C'
                )
            ),
            'font' => array(
                'name' => 'Calibri',
                'size' => 13,
                'align' => 'center',
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            )
        );
        //Generacion del excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:F1')->applyFromArray($titleStyle);
        $sheet->setCellValue('A1','Código');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Marca');
        $sheet->setCellValue('E1', 'Categoría');
        $sheet->setCellValue('F1', 'Precio');

        $line = 2;
        foreach ($products as $product){
            $sheet->setCellValue('A'.$line,$product->getCode());
            $sheet->setCellValue('B'.$line,$product->getName());
            $sheet->setCellValue('C'.$line,$product->getDescription());
            $sheet->setCellValue('D'.$line,$product->getTradeMark());
            $sheet->setCellValue('E'.$line,$product->getCategory()->getName());
            $sheet->setCellValue('F'.$line,$product->getPrice());
            $line ++;
        }

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ListProducts.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Excel2007($spreadsheet);
        $writer->save('php://output');
        die();
        //dump($products);die();
    }

    /**
     * @Route("/readexcel/{id}", name="reaExcelProducts")
     */
    public function readExcelAction(Product $product){

        $dir = $this->get('kernel')->getRootDir().'/../bin';
        $php = 'php';
        $command = sprintf('%s %s/console doctrine:mapping:info', $php, $dir);


        //dump($command);die();
        //$process = new Process('php bin/console doctrine:mapping:info');



        //$php = $this->container->getParameter('upload_data.php_bin');

        $process = new Process($command);
        $process->start();


        $process->wait(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
        /*while ($process->isRunning()) {
            // waiting for process to finish
        }
        echo $process->getOutput();*/

        /*
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });*/

        die('que paso');
    }

}
