<?php

namespace Logger\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QueryBuilder\DTO\ListDTO;

class ActionLogShowDTO {
    public function __construct(
        public readonly array $params,
    ) {}

    /**
     * fromRequest
     *
     * @param Request $request
     * @param int $id
     * @param ?callable $getValidUserId = null
     * @param ?callable $getValidOrganizationId = null
     *
     * @return ActionLogShowDTO
     */
    public static function fromRequest(
        Request $request,
        int $id,
        ?callable $getValidUserId = null,
        ?callable $getValidOrganizationId = null,
    ): ActionLogShowDTO {
        $authUser = Auth::user();

        $dto = ListDTO::fromRequest(
            $request,
            [ 'dateFrom', 'dateTo', 'userId', 'organizationId' ],
            [
                'bigName' => 'users.family_name',
                'phone' => 'users.phone'
            ]
        );

        $userId = $dto->params['user_id'];
        if ($getValidUserId) {
            $getValidUserId($authUser, $userId);
        }

        $organizationId = $dto->params['organization_id'];
        if ($getValidOrganizationId) {
            $getValidOrganizationId($authUser, $organizationId);
        }

        return new self(
            params: [
                ...$dto->params,
                'action_log_id' => $id,
                'created_by' => $userId,
                'organization_id' => $organizationId,
            ]
        );
    }

    /**
     * fromUserRequest
     *
     * @param Request $request
     * @param int $userId
     * @param ?callable $getValidUserId = null
     *
     * @return ActionLogShowDTO
     */
    public static function fromUserRequest(
        Request $request,
        int $userId,
        ?callable $getValidUserId = null,
    ): ActionLogShowDTO {
        $authUser = Auth::user();

        $dto = ListDTO::fromRequest(
            $request,
            [ 'actionLogId', 'dateFrom', 'dateTo', 'userId' ],
            [ 'actionLog' => 'logs.action_logs.id' ]
        );

        if ($getValidUserId) {
            $getValidUserId($authUser, $userId);
        }

        return new self(
            params: [
                ...$dto->params,
                'created_by' => $userId,
            ]
        );
    }

    /**
     * fromOrganizationRequest
     *
     * @param Request $request
     * @param int $organizationId
     * @param ?callable $getValidUserId = null
     * @param ?callable $getValidOrganizationId = null
     *
     * @return ActionLogShowDTO
     */
    public static function fromOrganizationRequest(
        Request $request,
        int $organizationId,
        ?callable $getValidUserId = null,
        ?callable $getValidOrganizationId = null,
    ): ActionLogShowDTO {
        $authUser = Auth::user();

        $dto = ListDTO::fromRequest(
            $request,
            [ 'actionLogId', 'dateFrom', 'dateTo', 'userId' ],
        );

        $userId = $dto->params['user_id'];
        if ($getValidUserId) {
            $getValidUserId($authUser, $userId);
        }

        if ($getValidOrganizationId) {
            $getValidOrganizationId($authUser, $organizationId);
        }

        return new self(
            params: [
                ...$dto->params,
                'created_by' => $userId,
                'organization_id' => $organizationId,
            ]
        );
    }
}
