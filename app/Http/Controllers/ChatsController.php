<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message as Mensaje;
use App\Conversation;
use App\Message;
use App\MessageFile;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['fileUpload']]);
    }

    /**
     * Fetch specific conversation
     *
     * @return Conversation
     */
    public function getConversation($id)
    {
      $conversation = Conversation::with('messages', 'messages.messageFile')->with('proveedor')->with('cliente')->findOrFail($id);
      return response()->json($conversation->toArray());
    }


    /**
     * Fetch conversation from proveedor
     *
     * @return Conversation
     */
    public function getConversationsProveedor($id)
    {
        $conversations = Conversation::where('proveedor_id','=',$id)->with('proveedor')->with('cliente')->get();
        return response()->json($conversations->toArray());
    }

    /**
     * Fetch conversation from cliente
     *
     * @return Conversation
     */
    public function getConversationsCliente($id)
    {
        $conversations = Conversation::where('cliente_id','=',$id)->with('proveedor')->with('cliente')->get();
        return response()->json($conversations->toArray());
    }

    /**
     * Store a new conversation
     *
     * @return Conversation
     */
    public function saveMessage(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);

        $newMessage = new Mensaje;

        $newMessage->senderName = $request->input('senderName');
        $newMessage->message = $request->input('message');

        if($request->input('fileMessage')){
            $file = new MessageFile;
            $file->filename = $request->input('fileMessage')['filename'];
            $file->filesize = $request->input('fileMessage')['filesize'];
            $file->filetype = $request->input('fileMessage')['filetype'];
            $file->binary = utf8_encode(base64_decode($request->input('fileMessage')['base64']));

            if(!$request->input('message')){
                $newMessage->message = ' ';
            }

            $conversation->messages()->save($newMessage);
            $newMessage->messageFile()->save($file);
        } else { $conversation->messages()->save($newMessage); }

        $broadcastMessage = Message::findOrFail($newMessage->id);

        broadcast(new MessageSent($conversation->id, $broadcastMessage))->toOthers();
        return response()->json($conversation->toArray());
    }

    
    /**
     * Return a particular message
     *
     * @return Conversation
     */
    public function getMessage($id)
    {
        $response = Message::with('messageFile')->findOrFail($id);
        return response()->json($response->toArray());
    }

    /**
     * Store a new conversation
     *
     * @return Conversation
     */
    public function newConversation(Request $request)
    {
        $conversation = new Conversation;

        $conversation->proveedor_id = $request->input('proveedor_id');
        $conversation->cliente_id = $request->input('cliente_id');

        if($conversation->save()){
            return response()->json($conversation->toArray());
        }
    }

    public function findConversation($provId,$cliId){
        $conversation = Conversation::where(['proveedor_id' => $provId,'cliente_id' => $cliId])->take(1)->get();
        if(!$conversation->first()){
            $conversation = new Conversation;
            $conversation->proveedor_id = $provId;
            $conversation->cliente_id = $cliId;
            $conversation->save();
            return response()->json($conversation->toArray());
        }

        $foundChat = $conversation->first();

        return response()->json($foundChat->toArray());
    }

    public function fileUpload(Request $request)
    {
        return response()->json($request->toArray());
    }


}
