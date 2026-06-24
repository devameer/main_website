<?php

namespace App\Livewire;

use Livewire\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    /**
     * Dispatch a toast notification to the browser.
     */
    protected function toast(string $type, string $message, ?string $title = null): void
    {
        $this->dispatch('notify', type: $type, message: $message, title: $title);
    }

    protected function toastSuccess(string $message, ?string $title = null): void
    {
        $this->toast('success', $message, $title);
    }

    protected function toastError(string $message, ?string $title = null): void
    {
        $this->toast('error', $message, $title);
    }

    protected function toastWarning(string $message, ?string $title = null): void
    {
        $this->toast('warning', $message, $title);
    }

    protected function toastInfo(string $message, ?string $title = null): void
    {
        $this->toast('info', $message, $title);
    }

    /**
     * Render a full-page view inside the admin layout with title + breadcrumbs.
     */
    protected function page(string $view, string $title, array $breadcrumbs = [], array $data = [])
    {
        return view($view, $data)
            ->layout('components.admin.layout')
            ->layoutData([
                'title' => $title,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
