<?php

namespace App\Controller;

use App\Entity\Stream;
use App\Entity\StreamReaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StreamController extends AbstractController
{
    #[Route('/live', name: 'app_stream_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $stream = $entityManager
            ->getRepository(Stream::class)
            ->findOneBy(['isActive' => true]);

        return $this->render('stream/index.html.twig', [
            'stream' => $stream
        ]);
    }

    #[Route('/stream/interact/{id}', name: 'stream_interact', methods: ['POST'])]
    public function interact(
        Stream $stream,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $reaction = new StreamReaction();
        $reaction->setType($data['type'] ?? 'comment');
        $reaction->setComment($data['comment'] ?? null);
        $reaction->setUsername($this->getUser()?->getUserIdentifier() ?? 'Guest');
        $reaction->setCreatedAt(new \DateTimeImmutable());
        $reaction->setStream($stream);

        $em->persist($reaction);
        $em->flush();

        return $this->json([
            'username' => $reaction->getUsername(),
            'comment' => $reaction->getComment(),
            'type' => $reaction->getType()
        ]);
    }
}