<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResponsibleAiService;
use App\Models\AuditLog;
use App\Models\KnowledgeDocument;
use App\Models\GovernancePolicy;

class AiController extends Controller
{
    protected $aiService;

    public function __construct(ResponsibleAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        return view('beranda');
    }

    public function reset(Request $request) 
    {
        $request->session()->forget('chat_history');
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }
        return back();
    }

    public function ask(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');
        $userId = auth()->id(); // Null if not logged in
        $history = session('chat_history', []);

        // Use the Responsible AI Service
        $result = $this->aiService->generateResponse($prompt, $userId, $history);

        // Store to session history for persistence (optional, if we want reload capability)
        $history = session('chat_history', []);
        $history[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];
        $history[] = [
            'role' => 'model', 
            'parts' => [['text' => $result['text']]],
            'risk_score' => $result['risk_score'] ?? 0,
            'confidence_score' => $result['confidence_score'] ?? 0,
            'sources' => $result['sources'] ?? []
        ];
        session(['chat_history' => $history]);

        return response()->json($result);
    }

    public function audit()
    {
        // Fetch logs (immutable / read-only view)
        $logs = \App\Models\AuditLog::latest()->paginate(20);
        return view('admin.audit', compact('logs'));
    }

    public function updateAuditStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,flagged,rejected'
        ]);

        $log = \App\Models\AuditLog::findOrFail($id);
        $log->update(['status' => $request->status]);

        return response()->json(['status' => 'success', 'new_status' => $log->status]);
    }

    public function destroyAuditLog($id)
    {
        $log = AuditLog::findOrFail($id);
        $log->delete();
        return response()->json(['status' => 'success']);
    }

    public function dashboard()
    {
        $totalLogs = AuditLog::count();
        $avgRisk = AuditLog::avg('risk_score') ?? 0;
        $totalFlagged = AuditLog::where('status', 'flagged')->count();
        $totalKnowledge = KnowledgeDocument::count();
        $activePolicies = GovernancePolicy::where('is_active', true)->count();

        // Calculate a "Safety Health" score (simple inverse of average risk)
        $safetyHealth = max(0, 100 - $avgRisk);

        return view('admin.dashboard', compact(
            'totalLogs', 
            'avgRisk', 
            'totalFlagged', 
            'totalKnowledge', 
            'activePolicies',
            'safetyHealth'
        ));
    }
}
