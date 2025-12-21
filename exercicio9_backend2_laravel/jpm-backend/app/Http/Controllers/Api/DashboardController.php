<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Denuncia;
use App\Models\Notificacao;
use Carbon\Carbon;

//teste
class DashboardController extends Controller
{
    public function index()
    {
        try {
            $now = Carbon::now();
            $trintaDiasAtras = $now->copy()->subDays(30);

            // ===== USUÁRIOS =====
            $totalUsuarios = Usuario::count();
            $usuariosAtivos = Usuario::where('status_conta', 'ATIVO')->count();
            
            // ✅ Usa ultima_atividade para calcular usuários ativos recentemente
            $usuariosAtivosRecente = Usuario::where('status_conta', 'ATIVO')
                                           ->where('ultima_atividade', '>=', $trintaDiasAtras)
                                           ->count();
            
            // ✅ Pode usar como "novos cadastros" ou deixar 0
            $novosCadastros = 0; // Sem created_at, não temos como calcular

            // ===== DENÚNCIAS =====
            $totalDenuncias = Denuncia::count();
            $denunciasResolvidas = Denuncia::whereIn('statusDenuncia', ['RESOLVIDO', 'RESOLVIDA'])
                                           ->count();
            $denunciasPendentes = Denuncia::where('statusDenuncia', 'PENDENTE')
                                          ->count();

            // ===== VIAGENS (quando implementar) =====
            $viagensRealizadas = 0; // Viagem::where('status', 'CONCLUIDA')->count();
            $cancelamentos = 0;     // Viagem::where('status', 'CANCELADA')->count();

            // ===== NOTIFICAÇÕES =====
            $totalNotificacoes = Notificacao::count();

            // ===== DISTRIBUIÇÃO POR TIPO =====
            $totalAdmins = Usuario::where('tipo_usuario', Usuario::TIPO_ADMIN)->count();
            $totalMotoristas = Usuario::where('tipo_usuario', Usuario::TIPO_MOTORISTA)->count();
            $totalPassageiros = Usuario::where('tipo_usuario', Usuario::TIPO_PASSAGEIRO)->count();

            // ===== CÁLCULO DE MUDANÇA (baseado em atividade recente) =====
            // Calcula a variação de usuários ativos nos últimos 30 dias
            $usuariosAtivosMesAnterior = Usuario::where('status_conta', 'ATIVO')
                                               ->where('ultima_atividade', '<', $trintaDiasAtras)
                                               ->count();
            
            $mudancaPercentual = $usuariosAtivosMesAnterior > 0
                ? round((($usuariosAtivosRecente - $usuariosAtivosMesAnterior) / $usuariosAtivosMesAnterior) * 100, 1)
                : 0;

            // Métrica principal: soma de atividades relevantes
            $usoPlatforma = $usuariosAtivos + $totalDenuncias + $viagensRealizadas + $totalNotificacoes;

            // ===== MONTA DADOS =====
            $data = [
                'metricas' => [
                    'uso_plataforma' => $usoPlatforma,
                    'total_usuarios' => $totalUsuarios,
                    'usuarios_ativos' => $usuariosAtivos,
                    'total_denuncias' => $totalDenuncias,
                ],
                
                'mudancas' => [
                    'uso_mudanca' => ($mudancaPercentual >= 0 ? '+' : '') . $mudancaPercentual . '%',
                ],
                
                'usage' => [
                    'usuarios_ativos'        => $usuariosAtivos,
                    'viagens_realizadas'     => $viagensRealizadas,
                    'denuncias_resolvidas'   => $denunciasResolvidas,
                    'novos_cadastros'        => $novosCadastros,
                    'cancelamentos'          => $cancelamentos,
                    'outros'                 => $totalNotificacoes,
                ],
                
                // ✅ EXTRAS (opcional - pode usar no front depois)
                'extras' => [
                    'denuncias_pendentes' => $denunciasPendentes,
                    'usuarios_por_tipo' => [
                        'administradores' => $totalAdmins,
                        'motoristas'      => $totalMotoristas,
                        'passageiros'     => $totalPassageiros,
                    ],
                    'usuarios_ativos_recente' => $usuariosAtivosRecente,
                ],
            ];

            return response()->json($data);

        } catch (\Exception $e) {
            \Log::error('Erro ao buscar métricas do dashboard: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'message' => 'Erro ao carregar métricas do dashboard',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}