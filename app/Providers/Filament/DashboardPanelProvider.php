<?php

namespace App\Providers\Filament;

use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->spa()
            ->id('dashboard')
            ->path('dashboard')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                NavigationGroup::make('Repair Cafe LB Info')
                    ->collapsed(),
                NavigationGroup::make('Other Resources')
                    ->icon('heroicon-o-globe-alt')
                    ->collapsed(),
            ])
            ->navigationItems([

                // Repair Cafe LB Info
                NavigationItem::make('Repair Cafe Homepage')
                    ->url(fn (): string => route('home'))
                    ->icon('heroicon-o-home')
                    ->group('Repair Cafe LB Info'),
                NavigationItem::make('More Information')
                    ->url(fn (): string => route('more-information'))
                    ->icon('heroicon-o-information-circle')
                    ->group('Repair Cafe LB Info'),
                NavigationItem::make('Policies')
                    ->url(fn (): string => route('policies'))
                    ->icon('heroicon-o-document-text')
                    ->group('Repair Cafe LB Info'),
                NavigationItem::make('Repair Disclaimer')
                    ->url(fn (): string => route('repair-disclaimer'))
                    ->icon('heroicon-o-exclamation-triangle')
                    ->group('Repair Cafe LB Info'),
                NavigationItem::make('Contact Us')
                    ->url(fn (): string => route('contact'))
                    ->icon('heroicon-o-envelope')
                    ->group('Repair Cafe LB Info'),

                // Other Resources
                NavigationItem::make('Totally Leighton Buzzard')
                    ->url('https://totallylb.wordpress.com/')
                    ->group('Other Resources')
                    ->openUrlInNewTab(),
                NavigationItem::make('Repair Cafe International')
                    ->url('https://www.repaircafe.org/en/')
                    ->group('Other Resources')
                    ->openUrlInNewTab(),
                NavigationItem::make('Restarters Group')
                    ->url('https://restarters.net/group/view/821')
                    ->group('Other Resources')
                    ->openUrlInNewTab(),
                NavigationItem::make('iFixit Repair Guides')
                    ->url('https://www.ifixit.com/Guide')
                    ->group('Other Resources')
                    ->openUrlInNewTab(),
                NavigationItem::make('Right to Repair')
                    ->url('https://repair.eu/')
                    ->group('Other Resources')
                    ->openUrlInNewTab(),

            ])
            ->discoverResources(in: app_path('Filament/Dashboard/Resources'), for: 'App\Filament\Dashboard\Resources')
            ->discoverPages(in: app_path('Filament/Dashboard/Pages'), for: 'App\Filament\Dashboard\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Dashboard/Widgets'), for: 'App\Filament\Dashboard\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->userMenuItems([
                Action::make('Account Settings')
                    ->url(fn (): string => route('settings.profile'))
                    ->icon('heroicon-o-cog-6-tooth'),
                Action::make('Admin Dashboard')
                    ->url(fn (): string => url('/admin'))
                    ->icon('heroicon-o-cog')
                    ->visible(fn (?\Illuminate\Contracts\Auth\Authenticatable $user) => $user?->can('access-admin-panel')),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
