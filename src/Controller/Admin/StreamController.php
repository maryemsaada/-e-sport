<?php

namespace App\Controller\Admin;

use App\Entity\Stream;
use App\Form\StreamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class StreamController extends AbstractController
{
    #[Route('/admin/stream', name: 'admin_stream_index')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        // Récupérer ou créer le flux actif
        $stream = $em->getRepository(Stream::class)->findOneBy(['isActive' => true]);
        if (!$stream) {
            $stream = new Stream();
            $stream->setIsActive(true);
            $em->persist($stream);
        }

        // Création du formulaire VichUploader
        $form = $this->createForm(StreamType::class, $stream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Vidéo mise à jour avec succès !');

            return $this->redirectToRoute('admin_stream_index');
        }

        return $this->render('admin/stream/index.html.twig', [
            'form' => $form->createView(),
            'streamUrl' => $stream->getUrl(),
            'stream' => $stream,
        ]);
    }
}