<?php

namespace App\Controller\Admin;

use App\Entity\LeaveRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ReviewLeaveRequestController extends AbstractController
{
    #[Route('/admin/review/leave_request/{id}', name: 'review_leave_request')]
    public function __invoke(
        Request $request,
        LeaveRequest $leaveRequest,
        WorkflowInterface $leaveRequestStateMachine,
        EntityManagerInterface $entityManager,
        Security $security,
    ): Response
    {
        $user = $security->getUser();
        if ($user) {
            $userRoles = $user->getRoles();
        } else {
            $userRoles = [];
        }
        $accepted = !$request->query->getBoolean('reject');
        if ($leaveRequestStateMachine->can($leaveRequest, 'accept')
        || $leaveRequestStateMachine->can($leaveRequest, 'reject')) {
            $result = $accepted ? 'accept' : 'reject';
        }
        $leaveRequestStateMachine->apply($leaveRequest, $result);
        $entityManager->flush();

        return $this->render('admin/review_leave_request.html.twig', [
            'roles' => $userRoles,
            'leaveRequest' => $leaveRequest]);
    }
}
