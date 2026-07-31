<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use App\Models\CreditApplicationDocument;
use App\Models\User;
use App\Enums\DossierStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function index(Request $request)
    {
        if (! $request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.login');
        }

        return $this->dashboard();
    }

    public function readNotification($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->route('admin.dossiers.show', $notification->data['application_id'] ?? 1);
    }

    public function unreadNotifications()
    {
        $user = auth()->user();
        $count = $user->unreadNotifications()->count();
        $notifications = $user->notifications()->take(10)->get();

        $html = '';
        foreach ($notifications as $notification) {
            $isUnread = $notification->unread();
            $bg = $isUnread ? 'background:#f8fafc;' : '';
            $hoverOn = $isUnread ? '#f1f5f9' : '#f1f5f9';
            $hoverOff = $isUnread ? '#f8fafc' : 'transparent';
            $route = route('admin.notifications.read', $notification->id);
            $msg = $notification->data['message'] ?? 'Nouveau dossier';
            $ref = $notification->data['reference'] ?? '';
            $time = $notification->created_at->diffForHumans();

            $html .= "<a href=\"{$route}\" style=\"display:flex; gap:12px; padding:0.75rem; border-radius:10px; text-decoration:none; {$bg}\" onmouseover=\"this.style.background='{$hoverOn}'\" onmouseout=\"this.style.background='{$hoverOff}'\">
                <div style=\"height:36px; width:36px; border-radius:50%; background:#dbeafe; color:#1d4ed8; display:flex; align-items:center; justify-content:center; flex-shrink:0;\">
                    <svg style=\"width:18px;height:18px;stroke:currentColor;\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z\" /></svg>
                </div>
                <div>
                    <div style=\"font-size:0.8rem; font-weight:600; color:#0f172a;\">{$msg} {$ref}</div>
                    <div style=\"font-size:0.7rem; color:#64748b; margin-top:2px;\">Il y a {$time}</div>
                </div>
            </a>";
        }

        if (empty($html)) {
            $html = '<div style="padding:1rem; text-align:center; color:#94a3b8; font-size:0.8rem;">Aucune notification</div>';
        }

        return response()->json([
            'count' => $count,
            'html' => $html
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if ($remember) {
            // Set remember me duration to 14 days (20160 minutes)
            /** @var \Illuminate\Auth\SessionGuard $guard */
            $guard = Auth::guard();
            $guard->setRememberDuration(20160);
        }

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Identifiants incorrects'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function statistics(Request $request)
    {
        $period = $request->get('period', '7d'); // '7d', '30d', '1y'

        $baseQuery = CreditApplication::query();
        if ($period === '7d') {
            $baseQuery->where('created_at', '>=', now()->subDays(7));
        } elseif ($period === '30d') {
            $baseQuery->where('created_at', '>=', now()->subDays(30));
        } elseif ($period === '1y') {
            $baseQuery->where('created_at', '>=', now()->subYear());
        }

        // Stats respect period
        $stats = [
            'total'         => (clone $baseQuery)->count(),
            'submitted'     => (clone $baseQuery)->where('status', 'a_qualifier')->count(),
            'processing'    => (clone $baseQuery)->whereIn('status', ['dossier_conforme', 'mandat_envoye', 'offre_emise', 'fonds_decaisses'])->count(),
            'completed'     => (clone $baseQuery)->where('status', 'cloture_succes')->count(),
            'new_this_month'=> CreditApplication::whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)->count(),
        ];

        $chartData = [];
        $chartLabels = [];

        if ($period === '7d' || $period === '30d') {
            $days = $period === '7d' ? 6 : 29;
            for ($i = $days; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $chartLabels[] = $date->translatedFormat('d M');
                $chartData[] = CreditApplication::whereDate('created_at', $date->toDateString())->count();
            }
        } else { // 1y
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $chartLabels[] = ucfirst($date->translatedFormat('M y'));
                $chartData[] = CreditApplication::whereMonth('created_at', $date->month)
                                                ->whereYear('created_at', $date->year)->count();
            }
        }

        $users = \App\Models\User::orderBy('name')->get();

        return view('admin.statistics', compact('stats', 'users', 'chartData', 'chartLabels', 'period'));
    }

    public function dossiersIndex(Request $request)
    {
        $perPage = in_array((int) $request->get('per_page'), [10, 20, 30, 40]) ? (int) $request->get('per_page') : 10;

        $query = CreditApplication::query()
            ->withCount('documents')
            ->where('is_archived', false)
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at');

        if ($search = $request->get('search')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('reference', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('nom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $dossierStatus = DossierStatus::tryFrom($status);
            if ($dossierStatus) {
                $query->where('status', $dossierStatus->value);
            }
        }

        $dossiers = $query->paginate($perPage)->withQueryString();

        return view('admin.dossiers.index', compact('dossiers', 'perPage'));
    }

    public function archives(Request $request)
    {
        $perPage = in_array((int) $request->get('per_page'), [10, 20, 30, 40]) ? (int) $request->get('per_page') : 10;

        $query = CreditApplication::query()
            ->withCount('documents')
            ->where('is_archived', true)
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at');

        if ($search = $request->get('search')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('reference', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('nom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $dossierStatus = DossierStatus::tryFrom($status);
            if ($dossierStatus) {
                $query->where('status', $dossierStatus->value);
            }
        }

        $dossiers = $query->paginate($perPage)->withQueryString();

        return view('admin.dossiers.archives', compact('dossiers', 'perPage'));
    }

    public function archiveDossier(CreditApplication $application)
    {
        $application->is_archived = true;
        $application->save();

        return back()->with('success', 'Le dossier a été archivé avec succès.');
    }

    public function unarchiveDossier(CreditApplication $application)
    {
        $application->is_archived = false;
        $application->save();

        return back()->with('success', 'Le dossier a été restauré avec succès.');
    }

    public function updateStatus(Request $request, CreditApplication $application)
    {
        $request->validate(['status' => 'required|string']);

        $status = \App\Enums\DossierStatus::tryFrom($request->status);
        if ($status) {
            $oldStatus = $application->status;
            $application->status = $status;
            $application->save();

            // Email de mise à jour de statut (hors approbation qui est gérée séparément)
            if ($oldStatus !== $status && $application->email && $status !== \App\Enums\DossierStatus::OffreEmise) {
                try {
                    \Illuminate\Support\Facades\Mail::to($application->email)->send(new \App\Mail\DossierStatusUpdated($application));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send status update email: ' . $e->getMessage());
                }
            }

            return back()->with('success', 'Statut mis à jour avec succès.');
        }

        return back()->with('error', 'Statut invalide.');
    }

    public function approvePreview(CreditApplication $application)
    {
        $defaultMessage = "Bonjour **{$application->prenom} {$application->nom}**,\n\nNous avons le plaisir de vous informer que votre demande de prêt a été **examinée et approuvée** par notre comité d'engagement.\n\nVeuillez trouver en pièce jointe votre **Offre de Contrat de Prêt**, qui récapitule l'ensemble des conditions et modalités de votre financement.\n\n**Prochaines étapes :**\n1. Lisez attentivement le contrat ci-joint\n2. Signez le document et retournez-le à votre conseiller\n3. Les fonds seront débloqués après réception du contrat signé\n\nPour toute question, notre équipe reste disponible.";

        return view('admin.dossiers.approve-preview', compact('application', 'defaultMessage'));
    }

    public function previewPdf(Request $request, CreditApplication $application)
    {
        if ($request->has('montant')) $application->montant = $request->montant;
        if ($request->has('duree_mois')) $application->duree_mois = $request->duree_mois;
        if ($request->has('taux_annuel')) $application->taux_annuel = $request->taux_annuel;

        $calculator = app(\App\Services\CreditCalculatorService::class);
        $application->mensualite = $calculator->mensualite(
            $application->montant,
            $application->duree_mois,
            $application->taux_annuel
        );

        $contractService = app(\App\Services\ContractPdfService::class);
        $amortization = $contractService->buildAmortization($application);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.contract', [
            'application'  => $application,
            'brand'        => config('credit.brand'),
            'amortization' => $amortization,
            'generatedAt'  => now(),
        ])
        ->setPaper('a4');

        $disposition = $request->query('download') ? 'attachment' : 'inline';
        $filename = $request->query('download') ? "Contrat_Pret_Brouillon_{$application->reference}.pdf" : 'preview.pdf';

        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "{$disposition}; filename=\"{$filename}\""
        ]);
    }

    public function previewEmail(Request $request, CreditApplication $application)
    {
        $customMessage = $request->query('message', '');
        $mail = new \App\Mail\ContractApprovedMail($application, '', $customMessage);
        return $mail->render();
    }

    public function approveConfirm(Request $request, CreditApplication $application)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1',
            'duree_mois' => 'required|integer|min:1',
            'taux_annuel' => 'required|numeric|min:0',
            'custom_message' => 'required|string',
        ]);

        // Mettre à jour les variables du contrat si modifiées
        $application->montant = $request->montant;
        $application->duree_mois = $request->duree_mois;
        $application->taux_annuel = $request->taux_annuel;

        // Recalculer la mensualité
        $calculator = app(\App\Services\CreditCalculatorService::class);
        $application->mensualite = $calculator->mensualite(
            $application->montant,
            $application->duree_mois,
            $application->taux_annuel
        );

        // Mettre à jour le statut
        $application->status = \App\Enums\DossierStatus::OffreEmise;
        $application->save();

        // Générer le contrat et envoyer le mail avec le message personnalisé
        if ($application->email) {
            try {
                $contractService = app(\App\Services\ContractPdfService::class);
                $pdfPath = $contractService->generate($application);
                \Illuminate\Support\Facades\Mail::to($application->email)
                    ->send(new \App\Mail\ContractApprovedMail($application, $pdfPath, $request->custom_message));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to generate/send contract: ' . $e->getMessage());
                return redirect()->route('admin.dossiers.show', $application)->with('warning', 'Le dossier est approuvé mais l\'envoi de l\'email a échoué : ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.dossiers.show', $application)->with('success', 'Dossier approuvé avec succès et contrat envoyé au client.');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'ids' => 'required|array',
            'ids.*' => 'exists:credit_applications,id'
        ]);

        $status = \App\Enums\DossierStatus::tryFrom($request->status);
        if ($status) {
            $applications = CreditApplication::whereIn('id', $request->ids)->get();
            foreach ($applications as $application) {
                $oldStatus = $application->status;
                $application->status = $status;
                $application->save();

                if ($oldStatus !== $status && $application->email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($application->email)->send(new \App\Mail\DossierStatusUpdated($application));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to send bulk status update email: ' . $e->getMessage());
                    }
                }
            }
            return back()->with('success', 'Dossiers mis à jour avec succès.');
        }

        return back()->with('error', 'Action de masse échouée.');
    }

    public function show(CreditApplication $application)
    {
        $application->load(['documents', 'notes.user']);
        return view('admin.show', compact('application'));
    }

    public function storeDossierNote(Request $request, CreditApplication $application)
    {
        $request->validate(['note' => 'required|string|max:1000']);
        \App\Models\DossierNote::create([
            'credit_application_id' => $application->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'note' => $request->note,
        ]);
        return back()->with('success', 'Note ajoutée avec succès.');
    }

    public function downloadDocument(CreditApplication $application, CreditApplicationDocument $document)
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isEmployee())) {
            abort(403, 'Accès non autorisé aux documents.');
        }

        if ($document->credit_application_id !== $application->id) {
            abort(404);
        }

        if (! Storage::disk($document->disk)->exists($document->path)) {
            abort(404);
        }

        return Storage::disk($document->disk)->download(
            $document->path,
            $document->original_filename,
            ['Content-Type' => $document->mime_type]
        );
    }

    // =============================================
    // PROFIL
    // =============================================

    public function profile()
    {
        $sessions = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderByDesc('last_activity')
            ->get();

        return view('admin.profile', [
            'user' => Auth::user(),
            'sessions' => $sessions
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->notification_preferences = $request->input('preferences', []);
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function logoutOtherDevices(Request $request)
    {
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', session()->getId())
            ->delete();

        return back()->with('success', 'Tous les autres appareils ont été déconnectés.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
        }

        $user->password = $request->password; // Le cast 'hashed' gère le hachage automatiquement
        $user->save();

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    // =============================================
    // PARAMÈTRES (admin only)
    // =============================================

    public function settings()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $users = User::orderBy('name')->get();

        return view('admin.settings', compact('users'));
    }

    public function createUser(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'     => ['required', 'in:admin,employee'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateUser(Request $request, User $user)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'  => ['required', 'in:admin,employee'],
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;
        $user->save();

        return back()->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function changeUserPassword(Request $request, User $user)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = $request->new_password; // Le cast 'hashed' gère le hachage automatiquement
        $user->save();

        return back()->with('success', 'Mot de passe de ' . $user->name . ' modifié avec succès.');
    }

    public function deleteUser(User $user)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
    public function clientsIndex(Request $request)
    {
        $perPage = in_array((int) $request->get('per_page'), [10, 20, 30, 40]) ? (int) $request->get('per_page') : 10;

        $sub = \App\Models\CreditApplication::selectRaw('email, MAX(prenom) as prenom, MAX(nom) as nom, SUM(montant) as total_credits, MIN(created_at) as first_seen')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->groupBy('email');

        $query = \Illuminate\Support\Facades\DB::table(\Illuminate\Support\Facades\DB::raw("({$sub->toSql()}) as clients"))
            ->mergeBindings($sub->getQuery())
            ->leftJoin('client_statuses', 'clients.email', '=', 'client_statuses.email')
            ->where(function($q) {
                $q->where('client_statuses.is_archived', false)
                  ->orWhereNull('client_statuses.is_archived');
            })
            ->select('clients.*', 'client_statuses.is_blocked', 'client_statuses.is_archived');

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('clients.prenom', 'like', "%{$search}%")
                  ->orWhere('clients.nom', 'like', "%{$search}%")
                  ->orWhere('clients.email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'blocked') {
                $query->where('client_statuses.is_blocked', true);
            } elseif ($status === 'active') {
                $query->where(function($q) {
                    $q->where('client_statuses.is_blocked', false)
                      ->orWhereNull('client_statuses.is_blocked');
                });
            }
        }

        $totalUsers = (clone $query)->count();
        $totalVolume = (clone $query)->sum('total_credits');
        
        $clients = $query->orderByDesc('first_seen')->paginate($perPage)->withQueryString();

        return view('admin.clients.index', compact('clients', 'totalUsers', 'totalVolume', 'perPage'));
    }

    public function clientsArchives(Request $request)
    {
        $perPage = in_array((int) $request->get('per_page'), [10, 20, 30, 40]) ? (int) $request->get('per_page') : 10;

        $sub = \App\Models\CreditApplication::selectRaw('email, MAX(prenom) as prenom, MAX(nom) as nom, SUM(montant) as total_credits, MIN(created_at) as first_seen')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->groupBy('email');

        $query = \Illuminate\Support\Facades\DB::table(\Illuminate\Support\Facades\DB::raw("({$sub->toSql()}) as clients"))
            ->mergeBindings($sub->getQuery())
            ->join('client_statuses', 'clients.email', '=', 'client_statuses.email')
            ->where('client_statuses.is_archived', true)
            ->select('clients.*', 'client_statuses.is_blocked', 'client_statuses.is_archived');

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('clients.prenom', 'like', "%{$search}%")
                  ->orWhere('clients.nom', 'like', "%{$search}%")
                  ->orWhere('clients.email', 'like', "%{$search}%");
            });
        }

        $totalUsers = (clone $query)->count();
        $totalVolume = (clone $query)->sum('total_credits');
        
        $clients = $query->orderByDesc('first_seen')->paginate($perPage)->withQueryString();

        return view('admin.clients.archives', compact('clients', 'totalUsers', 'totalVolume', 'perPage'));
    }



    public function clientsShow($email)
    {
        $dossiers = \App\Models\CreditApplication::with('documents')->where('email', $email)->orderByDesc('created_at')->get();
        if ($dossiers->isEmpty()) abort(404);
        
        $calculator = app(\App\Services\CreditCalculatorService::class);
        $clientInfo = (object) [
            'prenom' => $dossiers->first()->prenom,
            'nom' => $dossiers->first()->nom,
            'email' => $email,
            'first_seen' => $dossiers->last()->created_at,
            'total_credits' => $dossiers->sum('montant'),
            'score' => $calculator->scoreClient($dossiers->first()),
            'status' => \App\Models\ClientStatus::firstOrCreate(['email' => $email])
        ];

        $notes = \App\Models\ClientNote::with('user')->where('email', $email)->orderByDesc('created_at')->get();

        return view('admin.clients.show', compact('clientInfo', 'dossiers', 'notes'));
    }

    public function storeClientNote(Request $request, $email)
    {
        $request->validate(['note' => 'required|string|max:1000']);
        \App\Models\ClientNote::create([
            'email' => $email,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'note' => $request->note,
        ]);
        return back()->with('success', 'Note ajoutée avec succès.');
    }

    public function blockClient($email)
    {
        $status = \App\Models\ClientStatus::firstOrCreate(['email' => $email]);
        $status->is_blocked = !$status->is_blocked;
        $status->save();

        return back()->with('success', $status->is_blocked ? 'Client bloqué.' : 'Client débloqué.');
    }

    public function archiveClient($email)
    {
        $status = \App\Models\ClientStatus::firstOrCreate(['email' => $email]);
        $status->is_archived = !$status->is_archived;
        $status->save();

        if ($status->is_archived) {
            return redirect()->route('admin.clients.index')->with('success', 'Client archivé avec succès.');
        }

        return back()->with('success', 'Client désarchivé.');
    }

    public function clientsExport()
    {
        $sub = \App\Models\CreditApplication::selectRaw('email, MAX(prenom) as prenom, MAX(nom) as nom, SUM(montant) as total_credits, MIN(created_at) as first_seen')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->groupBy('email');

        $clients = \Illuminate\Support\Facades\DB::table(\Illuminate\Support\Facades\DB::raw("({$sub->toSql()}) as clients"))
            ->mergeBindings($sub->getQuery())
            ->orderByDesc('first_seen')
            ->get();

        $filename = "clients_" . date('Y-m-d') . ".csv";
        
        $callback = function() use ($clients) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Prénom', 'Nom', 'Email', 'Total Crédits (€)', 'Date Inscription'], ';');
            foreach ($clients as $client) {
                fputcsv($handle, [
                    $client->prenom,
                    $client->nom,
                    $client->email,
                    $client->total_credits,
                    \Carbon\Carbon::parse($client->first_seen)->format('Y-m-d H:i:s')
                ], ';');
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, ['Content-Type' => 'text/csv']);
    }
}
