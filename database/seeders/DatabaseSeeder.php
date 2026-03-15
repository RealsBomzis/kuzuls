<?php

namespace Database\Seeders;

use App\Enums\LinkKind;
use App\Enums\LinkReviewStatus;
use App\Models\{
    Galerija, GalerijasAttels, Jaunums, Kategorija, Lapa, Pasakums, Projekts, Role, SaturaSaite, User
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['nosaukums' => 'admin']);
        $editorRole = Role::firstOrCreate(['nosaukums' => 'darbinieks']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@kuzuls.test'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'is_active' => 1]
        );
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        $editor = User::firstOrCreate(
            ['email' => 'editor@kuzuls.test'],
            ['name' => 'Redaktors', 'password' => Hash::make('password'), 'is_active' => 1]
        );
        $editor->roles()->syncWithoutDetaching([$editorRole->id]);

        $katVisiem = Kategorija::firstOrCreate(['nosaukums' => 'Vispārīgi'], ['tips' => 'visiem']);
        $katPas = Kategorija::firstOrCreate(['nosaukums' => 'Pasākumi'], ['tips' => 'pasakumi']);
        $katProj = Kategorija::firstOrCreate(['nosaukums' => 'Projekti'], ['tips' => 'projekti']);
        $katNews = Kategorija::firstOrCreate(['nosaukums' => 'Jaunumi'], ['tips' => 'jaunumi']);
        $katGal = Kategorija::firstOrCreate(['nosaukums' => 'Galerijas'], ['tips' => 'galerijas']);
        $katLap = Kategorija::firstOrCreate(['nosaukums' => 'Lapas'], ['tips' => 'lapas']);

        Lapa::firstOrCreate(['slug' => 'par-biedribu'], [
            'virsraksts' => 'Par biedrību',
            'saturs' => "Kūzuls ir biedrība ar mērķi informēt sabiedrību un organizēt aktivitātes.\n\nŠī ir demo lapa, ko var labot CMS.",
            'kategorija_id' => $katLap->id,
            'publicets' => 1,
        ]);

        Lapa::firstOrCreate(['slug' => 'juridiska-informacija'], [
            'virsraksts' => 'Juridiskā informācija',
            'saturs' => "Šeit būs biedrības juridiskā informācija (demo).",
            'kategorija_id' => $katLap->id,
            'publicets' => 1,
        ]);

        // Events
        foreach (range(1, 6) as $i) {
            Pasakums::create([
                'nosaukums' => "Pasākums #$i",
                'apraksts' => "Apraksts pasākumam #$i. Demo saturs.",
                'norises_datums' => now()->addDays($i * 7)->toDateString(),
                'sakuma_laiks' => '18:00',
                'beigu_laiks' => '20:00',
                'vieta' => 'Rīga',
                'kategorija_id' => $katPas->id,
                'publicets' => 1,
                'izveidoja_user_id' => $editor->id,
            ]);
        }

        // Projects
        foreach (range(1, 5) as $i) {
            Projekts::create([
                'nosaukums' => "Projekts #$i",
                'apraksts' => "Detalizēts projekta #$i apraksts. Demo saturs.",
                'statuss' => $i % 3 === 0 ? 'pabeigts' : ($i % 2 === 0 ? 'aktivs' : 'planots'),
                'sakuma_datums' => now()->subMonths($i)->toDateString(),
                'beigu_datums' => $i % 3 === 0 ? now()->subMonths($i-1)->toDateString() : null,
                'kategorija_id' => $katProj->id,
                'publicets' => 1,
                'izveidoja_user_id' => $editor->id,
            ]);
        }

        // News
        foreach (range(1, 8) as $i) {
            Jaunums::create([
                'virsraksts' => "Jaunums #$i",
                'ievads' => "Īss ievads jaunumiem #$i.",
                'saturs' => "Pilns jaunuma #$i saturs.\n\nDemo teksts ar vairākām rindām.",
                'kategorija_id' => $katNews->id,
                'publicets' => 1,
                'publicesanas_datums' => now()->subDays($i)->toDateString(),
                'izveidoja_user_id' => $editor->id,
            ]);
        }

        // Gallery (no actual image files shipped; creates placeholders you can replace later)
        $g = Galerija::create([
            'nosaukums' => 'Galerija: Demo',
            'apraksts' => 'Demo galerija ar vietturiem.',
            'kategorija_id' => $katGal->id,
            'saistita_tips' => 'nav',
            'saistita_id' => null,
            'publicets' => 1,
        ]);

        foreach (range(1, 4) as $i) {
            GalerijasAttels::create([
                'galerija_id' => $g->id,
                'fails_cels' => 'placeholders/demo-'.$i.'.jpg',
                'alt_teksts' => "Demo attēls #$i",
                'seciba' => $i,
            ]);
        }

        // Approved auto link example (shown publicly)
        SaturaSaite::create([
            'avots_tips' => 'jaunumi',
            'avots_id' => 1,
            'merkis_tips' => 'pasakumi',
            'merkis_id' => 1,
            'tips' => LinkKind::Automatiskas->value,
            'atbilstibas_punkti' => 60,
            'review_status' => LinkReviewStatus::Approved->value,
            'izveidoja_user_id' => $admin->id,
        ]);
    }
}