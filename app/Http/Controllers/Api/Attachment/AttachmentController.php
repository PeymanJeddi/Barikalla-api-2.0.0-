<?php

namespace App\Http\Controllers\Api\Attachment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Attachment\AttachmentRequest;
use App\Http\Resources\Attachment\AttachmentResource;
use App\Http\Resources\Attachment\UploadTypeResource;
use App\Models\Attachment;
use App\Models\Kind;
use App\Services\AttachmentService;
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
     *               required={"file"},
     *               @OA\Property(property="file", type="file"),
     *               @OA\Property(property="type_id", type="integer", description="numeric id of upload type", example="5"),
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
    public function store(AttachmentRequest $request)
    {
        $user = $request->user();
        if ($request->has('type_id') && $request->type_id != '') {
            $uploadType = Kind::find($request->type_id);
            switch ($uploadType->key) {
                case 'avatar':
                    if ($user->avatar?->count() != 0) {
                        $this->attachmentService->deleteAttachment($user->avatar);
                    }
                    break;
                case 'birth-certificate':
                    if ($user->status != 'verified') {
                        if ($user->birthCertificate?->count() != 0) {
                            $this->attachmentService->deleteAttachment($user->birthCertificate);
                        }
                    } else {
                        return sendError('عدم دسترسی');
                    }
                    break;
                case 'national-card':
                    if ($user->status != 'verified') {
                        if ($user->birthCertificate?->count() != 0) {
                            $this->attachmentService->deleteAttachment($user->nationalCard);
                        }
                    } else {
                        return sendError('عدم دسترسی');
                    }
                    break;
            }
        }
        
        $attachment = $this->attachmentService->makeUpload($request->file('file'), $user, $request->type_id ?? null);
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

    /**
     * @OA\Get(
     * path="/api/attachment/config",
     * operationId="attachmentConfig",
     * tags={"Attachment"},
     * summary="Get attachment config",
     * security={ {"sanctum": {} }},
     * @OA\Response(
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
    public function config()
    {
        $uploadTypes = Kind::findBykey('upload_type')->get();
        return sendResponse('Attachment config', [
            'upload_types' => UploadTypeResource::collection($uploadTypes),
        ]);
    }
}
