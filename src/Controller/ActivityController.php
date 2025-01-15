<?php

namespace App\Controller;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ActivityController extends AbstractController
{
    #[Route('/api/activities', name: 'api_activity_create', methods:['POST'])]
    public function createActivity(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
    // Lire les données JSON
    $data = json_decode($request->getContent(), true);

    // Créer une nouvelle activité
    $activity = new Activity();
    $activity->setTypeSport($data['typeSport']);
    $activity->setActivityType($data['activityType']);
    $activity->setDuration((float) $data['duration']);
    $activity->setDate(new \DateTime($data['date'] ?? 'now'));
    $activity->setNotes($data['notes'] ?? null);
    $activity->setDifficulty((int) ($data['difficulty'] ?? 1));

    // Persister et sauvegarder
    $entityManager->persist($activity); // Prépare l'objet pour être sauvegardé
    $entityManager->flush(); // Exécute les requêtes SQL

    // Retourner une réponse JSON
    return new JsonResponse(['success' => true, 'message' => 'Activité ajoutée avec succès !']);
    }

    
}
