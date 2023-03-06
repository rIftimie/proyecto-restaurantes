<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;

#[Route('/products')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'app_products_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new (Request $request, ProductsRepository $productsRepository, SluggerInterface $slugger): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('img')->getData();
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid();
            // Move the file to the directory where brochures are stored
            //Cloudinary Api
            try {
                $image->move(
                    $this->getParameter('img_path'),
                    $newFilename
                );
                $product->setImg("https://res.cloudinary.com/dru9twkzb/image/upload/".$newFilename);
                // ... handle exception if something happens during file upload
            } catch (FileException $e) {
                dd($e);
            }
            $productsRepository->save($product, true);
            $cloudinary = new Cloudinary(
                [
                    'cloud' => [
                        'cloud_name' => 'dru9twkzb',
                        'api_key' => '457992937569669',
                        'api_secret' => 'qobHxRGhy2DrUi6RIbZKbtPguB4',
                    ],
                ]
            );
            $cloudinary->uploadApi()->upload(
                $this->getParameter('img_path') . '/' . $newFilename,
                ['public_id' => $newFilename]
            );
            $cloudinary->image($image)->resize(Resize::fill(100, 150))->toUrl();
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('products/new.html.twig', [
            'products' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    // Cloudinary API: Crea una url publica para la imagen seleccionada y la relaciona con la propiedad img
    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, ProductsRepository $productsRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('img')->getData();
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid();

            // move the file to the directory where brochures are stored
            try {
                $image->move(
                    $this->getParameter('img_path'),
                    $newFilename
                );
                $product->setImg("https://res.cloudinary.com/dru9twkzb/image/upload/".$newFilename);
                // ... handle exception if something happens during file upload
            } catch (FileException $e) {
                dd($e);
            }

            $productsRepository->save($product, true);

            $cloudinary = new Cloudinary(
                [
                    'cloud' => [
                        'cloud_name' => 'dru9twkzb',
                        'api_key' => '457992937569669',
                        'api_secret' => 'qobHxRGhy2DrUi6RIbZKbtPguB4',
                    ],
                ]
            );
            $cloudinary->uploadApi()->upload(
                $this->getParameter('img_path') . '/' . $newFilename,
                ['public_id' => $newFilename]
            );
            $cloudinary->image($image)->resize(Resize::fill(100, 150))->toUrl();

            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productsRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }

}