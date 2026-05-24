<?php
namespace GlpiPlugin\Aiticketrouter\View;

class FollowupView {
    public function render(array $data): string {
        $category     = $data['category'];
        $detected_kws = $data['detected_keywords'];
        $urgency      = (int)$data['urgency'];
        $impact       = (int)$data['impact'];
        $priority     = (int)$data['priority'];
        $ai_used      = $data['ai_used'];
        $suggested    = $data['suggested'];
        $all_techs    = $data['all_techs'];
        $solutions    = $data['solutions'];
        $max_tickets  = $data['max_tickets'] ?? 8;

        $ul      = [1=>'Très basse',2=>'Basse',3=>'Moyenne',4=>'Haute',5=>'Très haute'];
        $il      = [1=>'Très bas',  2=>'Bas',  3=>'Moyen',  4=>'Haut', 5=>'Majeur'];
        $kws_str = implode(', ', $detected_kws);
        $p_color = [1=>'#198754',2=>'#5cb85c',3=>'#f0a500',4=>'#fd7e14',5=>'#dc3545'][$priority] ?? '#6c757d';

        $solutions_html = is_array($solutions)
            ? '<ol style="margin:6px 0 0 0;padding-left:20px"><li>'
              . implode('</li><li>', array_map('htmlspecialchars', $solutions))
              . '</li></ol>'
            : $solutions;

        // ----------------------------------------------------------------
        // Bouton Appliquer - Version HTML direct (sans JS dynamique)
        // ----------------------------------------------------------------
        $applyBtn = function(string $field, int $value): string {
            return '<button type="button" class="aitr-apply-btn" data-field="' . $field . '" data-value="' . $value . '" style="margin-left:10px;padding:4px 12px;background:#4a6cf7;color:#fff;border-radius:10px;cursor:pointer;font-size:11px;font-weight:bold;border:none;transition:all 0.2s;"></button>';
        };

        // ----------------------------------------------------------------
        // Technicien recommandé
        // ----------------------------------------------------------------
        if ($suggested) {
            $pct     = min(100, (int)round(($suggested['open_tickets'] / $max_tickets) * 100));
            $bar_col = $suggested['open_tickets'] <= ($max_tickets * 0.5) ? '#198754'
                     : ($suggested['open_tickets'] <= ($max_tickets * 0.8) ? '#f0a500' : '#fd7e14');

            $suggest_html = '
    <div style="background:#f6fff8;border-left:4px solid #198754;padding:10px 14px;
                border-radius:0 6px 6px 0;margin-bottom:10px">
      <div style="font-size:11px;font-weight:700;color:#155724;text-transform:uppercase;
                  letter-spacing:.5px;margin-bottom:6px">Technicien recommandé</div>
      <div style="font-size:15px;font-weight:bold;color:#1a1a1a">'
          . htmlspecialchars($suggested['display_name']) . '</div>
      <div style="font-size:12px;color:#6c757d;margin-bottom:8px">Login : '
          . htmlspecialchars($suggested['name']) . '</div>
      <div style="font-size:12px;color:#555;margin-bottom:5px">Charge actuelle : '
          . $suggested['open_tickets'] . ' / ' . $max_tickets . ' tickets ouverts</div>
      <div style="background:#e9ecef;border-radius:4px;height:8px;max-width:260px">
        <div style="background:' . $bar_col . ';height:8px;border-radius:4px;width:' . $pct . '%"></div>
      </div>
    </div>';
        } else {
            $suggest_html = '
    <div style="background:#fff5f5;border-left:4px solid #dc3545;padding:10px 14px;
                border-radius:0 6px 6px 0;margin-bottom:10px;color:#dc3545;font-weight:bold">
      Aucun technicien disponible — tous ont ' . $max_tickets . ' tickets ouverts ou plus.
    </div>';
        }

        // ----------------------------------------------------------------
        // Tableau techniciens
        // ----------------------------------------------------------------
        $techs_rows = '';
        foreach ($all_techs as $t) {
            $over      = $t['open_tickets'] >= $max_tickets;
            $row_bg    = $over ? '#fff3cd' : '#fff';
            $badge_bg  = $over ? '#dc3545' : '#198754';
            $badge_lbl = $over ? 'Surchargé' : 'Disponible';
            $techs_rows .= '
          <tr style="background:' . $row_bg . '">
            <td style="padding:6px 10px;border:1px solid #dee2e6">'
                . htmlspecialchars($t['display_name']) . '</td>
            <td style="padding:6px 10px;border:1px solid #dee2e6;color:#6c757d">'
                . htmlspecialchars($t['name']) . '</td>
            <td style="padding:6px 10px;border:1px solid #dee2e6;text-align:center">'
                . $t['open_tickets'] . '/' . $max_tickets . '</td>
            <td style="padding:6px 10px;border:1px solid #dee2e6;text-align:center">
              <span style="background:' . $badge_bg . ';color:#fff;padding:2px 9px;
                           border-radius:10px;font-size:11px;font-weight:600">'
                . $badge_lbl . '</span>
            </td>
          </tr>';
        }

        $techs_table = '
    <div style="margin-bottom:14px">
      <div style="font-size:11px;font-weight:700;color:#495057;text-transform:uppercase;
                  letter-spacing:.5px;margin-bottom:8px">Tous les techniciens</div>
      <table style="width:100%;font-size:12px;border-collapse:collapse">
        <thead>
          <tr style="background:#f8f9fa">
            <th style="padding:6px 10px;text-align:left;border:1px solid #dee2e6">Nom</th>
            <th style="padding:6px 10px;text-align:left;border:1px solid #dee2e6">Login</th>
            <th style="padding:6px 10px;text-align:center;border:1px solid #dee2e6">Tickets ouverts</th>
            <th style="padding:6px 10px;text-align:center;border:1px solid #dee2e6">Statut</th>
          </tr>
        </thead>
        <tbody>' . $techs_rows . '
        </tbody>
      </table>
    </div>';

        // ----------------------------------------------------------------
        // Contenu principal
        // ----------------------------------------------------------------
        $content = '
    <div style="font-family:Arial,sans-serif;font-size:13px;line-height:1.7;
                color:#1a1a1a;max-width:700px">

      <div style="background:#f0f4ff;border-left:4px solid #4a6cf7;padding:10px 14px;
                  margin-bottom:14px;border-radius:0 6px 6px 0">
        <span style="font-size:14px;font-weight:bold;color:#4a6cf7">
          Analyse automatique — AI Ticket Router
        </span>
        ' . ($ai_used
            ? '<span style="float:right;font-size:11px;background:#4a6cf7;color:#fff;padding:2px 8px;border-radius:12px">🤖 Gemini AI</span>'
            : '<span style="float:right;font-size:11px;background:#6c757d;color:#fff;padding:2px 8px;border-radius:12px">📝 Mode mots-clés</span>'
        ) . '
      </div>

      

      <table style="width:100%;border-collapse:collapse;margin-bottom:16px;
                    font-size:12px;border:1px solid #dee2e6">
        <thead>
          <tr style="background:#4a6cf7;color:#fff">
            <th style="padding:7px 12px;text-align:left;width:30%">Critère</th>
            <th style="padding:7px 12px;text-align:left">Valeur suggérée par l\'IA</th>
          </tr>
        </thead>
        <tbody>

          <tr style="background:#f8f9fa">
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6">Catégorie</td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6">
              <strong>' . htmlspecialchars($category) . '</strong>
            </td>
          </tr>

          <tr>
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6">Mots-clés</td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6">
              ' . htmlspecialchars($kws_str ?: 'Aucun') . '
            </td>
          </tr>

          <!-- URGENCE -->
          <tr style="background:#f8f9fa">
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6">Urgence</td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6;vertical-align:middle">
              <span style="vertical-align:middle">' . $ul[$urgency] . ' (' . $urgency . '/5)</span>
              ' . $applyBtn('urgency', $urgency) . '
            </td>
          </tr>

          <!-- IMPACT -->
          <tr>
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6">Impact</td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6;vertical-align:middle">
              <span style="vertical-align:middle">' . $il[$impact] . ' (' . $impact . '/5)</span>
              ' . $applyBtn('impact', $impact) . '
            </td>
          </tr>

          <!-- PRIORITÉ -->
          <tr style="background:#f8f9fa">
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6">Priorité</td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6;vertical-align:middle">
              <span style="background:' . $p_color . ';color:#fff;padding:2px 10px;
                           border-radius:12px;font-weight:600;vertical-align:middle">
                ' . $ul[$priority] . ' (' . $priority . '/5)
              </span>
              ' . $applyBtn('priority', $priority) . '
            </td>
          </tr>

          <tr>
            <td style="padding:7px 12px;font-weight:600;border-top:1px solid #dee2e6;vertical-align:top">
              Technicien suggéré
            </td>
            <td style="padding:7px 12px;border-top:1px solid #dee2e6">
              ' . (
                $suggested
                  ? '<strong>' . htmlspecialchars($suggested['display_name']) . '</strong>'
                    . ' <span style="color:#6c757d;font-size:11px">(login : '
                    . htmlspecialchars($suggested['name']) . ')</span>'
                    . ' — <span style="color:#198754;font-weight:600">'
                    . $suggested['open_tickets'] . ' ticket(s) ouvert(s)</span>'
                  : '<span style="color:#dc3545;font-weight:600">Aucun disponible</span>'
              ) . '
            </td>
          </tr>

        </tbody>
      </table>

      ' . $suggest_html . '
      ' . $techs_table . '

      <div style="background:#f6fff8;border-left:4px solid #198754;padding:10px 14px;
                  border-radius:0 6px 6px 0;margin-bottom:12px">
        <div style="font-weight:600;color:#155724;margin-bottom:4px">Pistes de résolution suggérées</div>
        ' . $solutions_html . '
      </div>

      <div style="font-size:11px;color:#6c757d;border-top:1px solid #dee2e6;padding-top:8px">
        Analyse générée automatiquement par AI Ticket Router.
      </div>

    </div>';

return $content;
    }
}