<?php

namespace App\Http\Controllers\Api\Attachment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Attachment\AttachmentRequest;
use App\Http\Resources\Attachment\AttachmentResource;
use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttachmentController extends Controller
{
    public function __construct(public AttachmentService $attachmentService)
    {

    }
    
    /**
     * @OA\Post(
     * path="/api/attachment",
     * operationId="uploadAttachment",
     * tags={"Attachment"},
     * summary="Upload attachment",
     * security={ {"sanctum": {} }},
     *         @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"file", "type"},
     *               @OA\Property(property="file", type="file"),
     *               @OA\Property(property="type", type="string", description="avatar", example="avatar"),
     *            ),
     *        ),
     *    ),
     *    
     *    @OA\Response(
     *    response=200,
     *    description="Your request has been successfully completed.",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example="true"),
     *       @OA\Property(property="message", type="string", example="Your request has been successfully completed."),
     *       @OA\Property(property="data"),
     *        )
     *     ),
     * )
     */
    public function upload(AttachmentRequest $request)
    {
        $user = $request->user();
        if ($request->type == 'avatar' && $user->avatar?->count() != 0) {
            $this->attachmentService->deleteAttachment($user->avatar);
        }
        $attachment = $this->attachmentService->makeUpload($request->file('file'), $user, $request->type);
        return sendResponse('عکس با موفقیت آپلود شد', ['attachment' => new AttachmentResource($attachment)]);
    }

        /**
     * @OA\Delete(
     * path="/api/attachment/{attachment}",
     * operationId="deleteFile",
     * tags={"Attachment"},
     * summary="Delete a file",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="attachment",in="path",description="14",required=true),
     * 
     *    @OA\Response(
     *    response=200,
     *    description="Your request has been successfully completed.",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example="true"),
     *       @OA\Property(property="message", type="string", example="Your request has been successfully completed."),
     *       @OA\Property(property="data"),
     *        )
     *     ),
     * )
     */
    public function destroy(Attachment $attachment)
    {
        Gate::authorize('delete', $attachment);
        $this->attachmentService->deleteAttachment($attachment);
        return sendResponse('عکس با موفقیت حذف شد', []);
    }
}
