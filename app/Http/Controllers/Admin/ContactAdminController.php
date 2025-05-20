<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Contact\ContactAdminService;
use App\Models\Contact as Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    protected $contactAdminService;
    public function __construct(ContactAdminService $contactAdminService)
    {
        $this->contactAdminService = $contactAdminService;
    }
    public function index(Contact $contact, Request $request){
        $status = $request->query('status', 'all');
        $query = Contact::query();

        if ($status == 'pending') {
            $query->where('status', 'pending');
        } elseif ($status == 'replied') {
            $query->where('status', 'replied');
        }

        $messageCount = $this->contactAdminService->getMessageCount();
        return view("admin.contact.contact", [
            'title' => "Tin nhắn của khách hàng",
            'contacts' => $this->contactAdminService->getAll(),
            'messageCount' => $messageCount
        ]);
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->contactAdminService->destroy($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa tin nhắn thành công'
            ]);
        }
        return response()->json([
            'error' =>true
        ]);
    }

    public function markAsReplied($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'replied']);

        return redirect()->back()->with('success', 'Đã đánh dấu phản hồi!');
    }

    public function pending()
    {
        return view("admin.contact.contact", [
            'title' => "Tin nhắn chưa phản hồi",
            'contacts' => Contact::where('status', 'pending')->orderBy('updated_at', 'desc')->paginate(10),
            'messageCount' => Contact::where('status', 'pending')->count()
        ]);
    }

    public function replied()
    {
        return view("admin.contact.contact", [
            'title' => "Tin nhắn đã phản hồi",
            'contacts' => Contact::where('status', 'replied')->orderBy('updated_at', 'desc')->paginate(10),
            'messageCount' => Contact::where('status', 'pending')->count() // Đếm số tin chưa phản hồi
        ]);
    }
}
