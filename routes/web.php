<?php

use App\Http\Controllers\Site\ArticleController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PageController;
use App\Livewire\Admin\Articles\Form;
use App\Livewire\Admin\Articles\Index as ArticlesIndex;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Comments;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Media;
use App\Livewire\Admin\Messages;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Projects\Index as ProjectsIndex;
use App\Livewire\Admin\Projects\Form as ProjectsForm;
use App\Livewire\Admin\Services\Index as ServicesIndex;
use App\Livewire\Admin\Services\Form as ServicesForm;
use App\Livewire\Admin\Testimonials\Index as TestimonialsIndex;
use App\Livewire\Admin\Testimonials\Form as TestimonialsForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// ─── Admin panel ─────────────────────────────────────────────────────────────

Route::prefix('admin')->group(function () {

    Route::get('/', Dashboard::class)->name('admin.dashboard');

    Route::prefix('articles')->group(function () {
        Route::get('/', ArticlesIndex::class)->name('admin.articles.index');
        Route::get('/create', Form::class)->name('admin.articles.create');
        Route::get('/{article}/edit', Form::class)->name('admin.articles.edit');
    });

    Route::get('/categories', Categories::class)->name('admin.categories.index');
    Route::get('/media', Media::class)->name('admin.media.index');

    Route::get('/projects', ProjectsIndex::class)->name('admin.projects.index');
    Route::get('/projects/create', ProjectsForm::class)->name('admin.projects.create');
    Route::get('/projects/{project}/edit', ProjectsForm::class)->name('admin.projects.edit');

    Route::get('/services', ServicesIndex::class)->name('admin.services.index');
    Route::get('/services/create', ServicesForm::class)->name('admin.services.create');
    Route::get('/services/{service}/edit', ServicesForm::class)->name('admin.services.edit');

    Route::get('/testimonials', TestimonialsIndex::class)->name('admin.testimonials.index');
    Route::get('/testimonials/create', TestimonialsForm::class)->name('admin.testimonials.create');
    Route::get('/testimonials/{testimonial}/edit', TestimonialsForm::class)->name('admin.testimonials.edit');
    Route::get('/messages', Messages::class)->name('admin.messages.index');
    Route::get('/comments', Comments::class)->name('admin.comments.index');
    Route::get('/users', Users::class)->name('admin.users.index');
    Route::get('/settings', Settings::class)->name('admin.settings');

    Route::get('/markdown/{name}/download', function (string $name) {
        $name = basename($name);
        if (! preg_match('/^[A-Za-z0-9._-]+$/', $name)) {
            abort(404);
        }
        $disk = Storage::disk('local');
        if (! $disk->exists("markdown/{$name}")) {
            abort(404);
        }

        return $disk->download("markdown/{$name}");
    })->where('name', '.+')->name('admin.markdown.download');
});

// ─── Public site (localized: /en, /ar) ───────────────────────────────────────

Route::get('/', function () {
    $preferred = (string) $locale = request()->session()->get('locale', '');

    if (! in_array($preferred, ['ar', 'en'], true)) {
        $browser = substr((string) request()->getPreferredLanguage(), 0, 2);
        $preferred = $browser === 'ar' ? 'ar' : 'en';
    }

    return redirect("/{$preferred}");
});

Route::prefix('{locale}')
    ->where(['locale' => 'en|ar'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
        Route::get('/work', [PageController::class, 'work'])->name('work');
        Route::get('/work/{slug}', [PageController::class, 'workShow'])->name('work.show');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/services', [PageController::class, 'services'])->name('services');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    });
