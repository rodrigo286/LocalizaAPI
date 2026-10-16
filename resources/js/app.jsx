import React from 'react';
import { createRoot } from 'react-dom/client';

const modules = [
    { title: 'Reservas', endpoints: ['POST /api/v1/reservations', 'GET /api/v1/vehicles', 'POST /api/v1/coupons/applications'] },
    { title: 'Telemetria e Frotas', endpoints: ['GET /api/v1/vehicles/{id}/telemetry', 'PUT /api/v1/vehicles/{id}/driver', 'POST /api/v1/vehicles/{id}/geofences'] },
    { title: 'Operações e Manutenção', endpoints: ['POST /api/v1/claims', 'POST /api/v1/maintenance-appointments', 'GET /api/v1/vehicles/{id}/maintenance-history'] },
    { title: 'Financeiro e Infrações', endpoints: ['GET /api/v1/billing-statements', 'GET /api/v1/traffic-fines'] },
];

function App() {
    return (
        <main className="min-h-screen bg-slate-950 text-white">
            <div className="mx-auto max-w-6xl px-6 py-10">
                <header className="rounded-3xl bg-emerald-500 p-8 text-slate-950 shadow-xl">
                    <p className="text-sm font-bold uppercase tracking-widest">Copilot Studio Workshop</p>
                    <h1 className="mt-2 text-4xl font-black">API de Mobilidade &amp; Frotas</h1>
                    <p className="mt-3 max-w-3xl">Sandbox educacional com dados fictícios para demonstração de agentes, fluxos e integrações.</p>
                </header>
                <section className="mt-6 grid gap-4 md:grid-cols-2">
                    {modules.map((module) => (
                        <article key={module.title} className="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                            <h2 className="text-xl font-bold text-emerald-400">{module.title}</h2>
                            <div className="mt-4 space-y-2">
                                {module.endpoints.map((endpoint) => (
                                    <code key={endpoint} className="block rounded-lg bg-slate-800 p-3 text-sm text-slate-200">{endpoint}</code>
                                ))}
                            </div>
                        </article>
                    ))}
                </section>
            </div>
        </main>
    );
}

createRoot(document.getElementById('app')).render(<App />);
