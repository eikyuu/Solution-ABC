<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Member;
use App\Form\MemberType;
use Symfony\Component\Mime\Email;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/member")
 */
class MemberController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="member_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $member->setRoles(['ROLE_MEMBER']);
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/new.html.twig', [
        'member' => $member,
        'form' => $form->createView()
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="member_show", methods={"GET"})
     */
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
        'member' => $member,
        ]);
    }
    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        
        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            if ($this->getUser()->getId() !== $member->getId()) {
                return $this->redirectToRoute('default');
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/edit.html.twig', [
        'member' => $member,
        'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="member_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index');
    }
}
