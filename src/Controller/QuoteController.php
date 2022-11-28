<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quotes')]
class QuoteController extends AbstractController
{

    #[Route('/', name: 'app_quote_index', methods: ['GET'])]
    public function index(Request $request, QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findAll();

        return $this->render('quote/index.html.twig', [
            'quotes' => $quotes,
        ]);
    }

    #[Route('/search', name: 'app_quote_search', methods: ['GET'])]
    public function search(Request $request, QuoteRepository $quoteRepository): Response
    {

        $query = $request->query->get('query');
        if (empty($query)) {
            return $this->redirectToRoute('app_quote_index');
        }
        $quotes = $quoteRepository->findAllByQuery($query);

        return $this->render('quote/index.html.twig', [
            'quotes' => $quotes,
        ]);
    }

    #[Route('/new', name: 'app_quote_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuoteRepository $quoteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quoteRepository->save($quote, true);

            return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quote/new.html.twig', [
            'quote' => $quote,
            'form' => $form,
        ]);
    }

    #[Route('/random', name: 'app_quote_random', methods: ['GET'])]
    public function random(Request $request, QuoteRepository $quoteRepository): Response
    {
        $quote = $quoteRepository->getRandomQuote();

        return $this->render('quote/index.html.twig', [
            'quotes' => [$quote],
        ]);
    }

    #[Route('/{id}', name: 'app_quote_show', methods: ['GET'])]
    public function show(Quote $quote): Response
    {
        return $this->render('quote/show.html.twig', [
            'quote' => $quote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quote_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quote $quote, QuoteRepository $quoteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quoteRepository->save($quote, true);

            return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quote/edit.html.twig', [
            'quote' => $quote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quote_delete', methods: ['POST'])]
    public function delete(Request $request, Quote $quote, QuoteRepository $quoteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $quote->getId(), $request->request->get('_token'))) {
            $quoteRepository->remove($quote, true);
        }

        return $this->redirectToRoute('app_quote_index', [], Response::HTTP_SEE_OTHER);
    }
}
