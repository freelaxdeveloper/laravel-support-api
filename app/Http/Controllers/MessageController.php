<?php

namespace App\Http\Controllers;

use Exception;
use App\{Events\MessageEvent, Events\MessageRemoveEvent, Message, Services\FileService};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Message as MessageResource;

class MessageController extends Controller
{
    /**
     * @param Message $message
     * @return MessageController|JsonResponse
     * @throws Exception
     */
    public function destroy(Message $message)
    {
        if (!$message->delete()) {
            return $this-fail();
        }

        MessageRemoveEvent::dispatch($message->id);

        return $this->success([
            Message::TYPE => 'system',
            Message::MESSAGE => 'This message has been removed',
        ]);
    }

    /**
     * @param Message $message
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Message $message, Request $request)
    {
        validator($request->all(), [
            'message' => 'string',
        ])->validate();

        $data = $request->only([
            Message::MESSAGE
        ]);

        $message->fill($data);

        return $this->responseIf($message->save());
    }

    /**
     * @param Message $message
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFile(Message $message, Request $request)
    {
        validator($request->all(), [
            'file' => 'required|max:10000',
        ])->validate();

        $file = $request->file('file');

        $message->file = FileService::save($file);
        $message->save();

        return $this->success(new MessageResource($message));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        validator($request->all(), [
            'data.text' => 'required_without_all:data.emoji,data.file|string',
            'data.emoji' => 'string',
            'type' => 'required|in:emoji,text,file',
        ])->validate();

        $data = [];
        $data[Message::MESSAGE] = $request->input('data.text') ?? $request->input('data.emoji');
        $data[Message::TYPE] = $request->input(Message::TYPE);
        $data[Message::GUEST_ID] = customer()->guest->id;

        $message = Message::create($data);

        MessageEvent::dispatch($message->id);

        return $this->success(new MessageResource($message));
    }

    /**
     * @param Message $message
     * @return JsonResponse
     */
    public function like(Message $message)
    {
        $message->{Message::IS_LIKE} = !$message->{Message::IS_LIKE};

        return $this->responseIf($message->save());
    }
}
