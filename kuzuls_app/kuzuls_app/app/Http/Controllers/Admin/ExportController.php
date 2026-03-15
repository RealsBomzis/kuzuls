<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pasakums, Projekts, Jaunums, Galerija, KontaktZinojums, Lapa};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function csv(string $resource)
    {
        [$title, $rows] = $this->resourceData($resource);

        return new StreamedResponse(function () use ($rows) {
            $out = fopen('php://output', 'w');
            if (!$out) return;

            if (count($rows) === 0) {
                fputcsv($out, ['Nav datu']);
                fclose($out);
                return;
            }

            fputcsv($out, array_keys($rows[0]));
            foreach ($rows as $r) fputcsv($out, $r);
            fclose($out);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$resource}.csv\"",
        ]);
    }

    public function pdf(string $resource)
    {
        [$title, $rows] = $this->resourceData($resource);

        $pdf = Pdf::loadView('admin.exports.table', [
            'title' => $title,
            'rows' => $rows,
        ]);

        return $pdf->download("{$resource}.pdf");
    }

    private function resourceData(string $resource): array
    {
        return match ($resource) {
            'pasakumi' => ['Pasākumi', Pasakums::latest('id')->get()->map(fn($p)=>[
                'ID'=>$p->id,'Nosaukums'=>$p->nosaukums,'Datums'=>$p->norises_datums,'Vieta'=>$p->vieta,'Publicēts'=>$p->publicets ? 'Jā':'Nē'
            ])->all()],
            'projekti' => ['Projekti', Projekts::latest('id')->get()->map(fn($p)=>[
                'ID'=>$p->id,'Nosaukums'=>$p->nosaukums,'Statuss'=>$p->statuss?->value,'Sākums'=>$p->sakuma_datums,'Beigas'=>$p->beigu_datums,'Publicēts'=>$p->publicets ? 'Jā':'Nē'
            ])->all()],
            'jaunumi' => ['Jaunumi', Jaunums::latest('id')->get()->map(fn($j)=>[
                'ID'=>$j->id,'Virsraksts'=>$j->virsraksts,'Publicēšanas datums'=>$j->publicesanas_datums,'Publicēts'=>$j->publicets ? 'Jā':'Nē'
            ])->all()],
            'galerijas' => ['Galerijas', Galerija::latest('id')->get()->map(fn($g)=>[
                'ID'=>$g->id,'Nosaukums'=>$g->nosaukums,'Publicēts'=>$g->publicets ? 'Jā':'Nē'
            ])->all()],
            'lapas' => ['Lapas', Lapa::latest('id')->get()->map(fn($l)=>[
                'ID'=>$l->id,'Slug'=>$l->slug,'Virsraksts'=>$l->virsraksts,'Publicēts'=>$l->publicets ? 'Jā':'Nē'
            ])->all()],
            'kontakt' => ['Kontaktziņojumi', KontaktZinojums::orderByDesc('izveidosanas_datums')->get()->map(fn($k)=>[
                'ID'=>$k->id,'Vārds'=>$k->vards,'E-pasts'=>$k->epasts,'Tēma'=>$k->tema,'Statuss'=>$k->statuss?->value,'Datums'=>$k->izveidosanas_datums
            ])->all()],
            default => abort(404),
        };
    }
}