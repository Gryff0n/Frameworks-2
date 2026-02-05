<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Form\CoursResponsableType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Seuls les responsables de formation peuvent créer des cours
        // On vérifie que l'utilisateur a au moins une formation dont il est responsable
        $user = $this->getUser();
        if (!$user || $user->getFormationsResponsable()->isEmpty()) {
            $this->addFlash('error', 'Vous devez être responsable d\'au moins une formation pour créer un cours.');
            return $this->redirectToRoute('app_cours_index');
        }

        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();

            $this->addFlash('success', 'Le cours a été créé avec succès.');
            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        // Vérifier si l'utilisateur a le droit de modifier ce cours
        $canEditFull = $this->isGranted('COURS_EDIT', $cour); // Responsable de formation
        $canEditLimited = $this->isGranted('COURS_EDIT_LIMITED', $cour); // Responsable de cours

        if (!$canEditFull && !$canEditLimited) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour modifier ce cours.');
            return $this->redirectToRoute('app_cours_show', ['id' => $cour->getId()]);
        }

        // Utiliser le formulaire approprié selon les droits
        if ($canEditFull) {
            $form = $this->createForm(CoursType::class, $cour);
        } else {
            // Responsable de cours : formulaire limité
            $form = $this->createForm(CoursResponsableType::class, $cour);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Le cours a été modifié avec succès.');
            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
            'is_limited_edit' => $canEditLimited && !$canEditFull,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        // Seul le responsable de formation peut supprimer
        if (!$this->isGranted('COURS_DELETE', $cour)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer ce cours.');
            return $this->redirectToRoute('app_cours_show', ['id' => $cour->getId()]);
        }

        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
            $this->addFlash('success', 'Le cours a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/remove-enseignant', name: 'app_cours_remove_enseignant', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function removeEnseignant(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        // Un enseignant peut se retirer du cours
        if (!$this->isGranted('COURS_REMOVE_ENSEIGNANT', $cour)) {
            $this->addFlash('error', 'Vous ne faites pas partie de ce cours.');
            return $this->redirectToRoute('app_cours_show', ['id' => $cour->getId()]);
        }

        if ($this->isCsrfTokenValid('remove-enseignant'.$cour->getId(), $request->getPayload()->getString('_token'))) {
            $user = $this->getUser();
            $cour->removeEnseignant($user);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez été retiré de ce cours.');
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}