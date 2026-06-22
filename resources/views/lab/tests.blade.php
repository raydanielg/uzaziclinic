@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">

        <!-- Hero Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="hero-card p-4 p-md-5" style="background: linear-gradient(135deg, #0f4c3a 0%, #166534 50%, #15803d 100%); border-radius: 24px; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -40px; right: -40px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.06);"></div>
                    <div style="position: absolute; bottom: -30px; left: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
                    <div class="row align-items-center position-relative" style="z-index: 1;">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px;">
                                    <i class="fa-solid fa-flask fs-3 text-white"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold text-white mb-0" style="font-size: 1.6rem;">Lab Tests Catalog</h2>
                                    <p class="text-white text-opacity-75 mb-0 small">Manage and configure all laboratory tests</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-light rounded-3 px-4 fw-bold shadow" data-bs-toggle="modal" data-bs-target="#addTestModal" style="color: #166534;">
                                <i class="fa-solid fa-plus me-2"></i>Add New Test
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            @php
                $totalTests = $tests->count();
                $activeTests = $tests->where('status', 'active')->count();
                $hematologyCount = $tests->where('category', 'Hematology')->count();
                $biochemistryCount = $tests->where('category', 'Biochemistry')->count();
                $microbiologyCount = $tests->where('category', 'Microbiology')->count();
                $otherCount = $totalTests - $hematologyCount - $biochemistryCount - $microbiologyCount;
            @endphp
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-vials"></i></div>
                        <div>
                            <div class="stat-label">Total Tests</div>
                            <div class="stat-value">{{ $totalTests }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-check-double"></i></div>
                        <div>
                            <div class="stat-label">Active Tests</div>
                            <div class="stat-value">{{ $activeTests }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-droplet"></i></div>
                        <div>
                            <div class="stat-label">Hematology</div>
                            <div class="stat-value">{{ $hematologyCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-dna"></i></div>
                        <div>
                            <div class="stat-label">Biochemistry</div>
                            <div class="stat-value">{{ $biochemistryCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-rose h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-rose"><i class="fa-solid fa-bacterium"></i></div>
                        <div>
                            <div class="stat-label">Microbiology</div>
                            <div class="stat-value">{{ $microbiologyCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card-modern stat-card-green-soft h-100">
                    <div class="card-body d-flex align-items-center gap-3" style="padding: 1.2rem 1rem;">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-list"></i></div>
                        <div>
                            <div class="stat-label">Others</div>
                            <div class="stat-value">{{ $otherCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-3"><i class="fa-solid fa-search text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 rounded-end-3" id="testSearch" placeholder="Search by test name, category...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-light rounded-3 fw-semibold small active-filter" data-filter="all">
                                        <i class="fa-solid fa-layer-group me-1"></i>All
                                    </button>
                                    <button class="btn btn-light rounded-3 fw-semibold small" data-filter="active">
                                        <i class="fa-solid fa-circle-check me-1 text-success"></i>Active
                                    </button>
                                    <button class="btn btn-light rounded-3 fw-semibold small" data-filter="inactive">
                                        <i class="fa-solid fa-circle-xmark me-1 text-secondary"></i>Inactive
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <span class="text-muted small fw-semibold">{{ $tests->count() }} tests found</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tests Grid -->
        <div class="row g-3" id="testsGrid">
            @forelse($tests as $test)
            @php
                $categoryColors = [
                    'Hematology' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#dc2626', 'icon' => 'fa-droplet'],
                    'Biochemistry' => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'text' => '#2563eb', 'icon' => 'fa-dna'],
                    'Microbiology' => ['bg' => '#fdf4ff', 'border' => '#e9d5ff', 'text' => '#9333ea', 'icon' => 'fa-bacterium'],
                    'Serology' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-shield-virus'],
                    'Urinalysis' => ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'text' => '#059669', 'icon' => 'fa-glass-water'],
                    'Parasitology' => ['bg' => '#f0f9ff', 'border' => '#bae6fd', 'text' => '#0284c7', 'icon' => 'fa-worm'],
                ];
                $cat = $test->category ?? 'General';
                $style = $categoryColors[$cat] ?? ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'text' => '#64748b', 'icon' => 'fa-vial'];
                
                $sampleIcons = [
                    'Blood' => 'fa-droplet',
                    'Urine' => 'fa-glass-water',
                    'Stool' => 'fa-poop',
                    'Sputum' => 'fa-lungs',
                    'Swab' => 'fa-qrcode',
                ];
                $sampleIcon = $sampleIcons[$test->sample_type ?? 'Blood'] ?? 'fa-vial';
            @endphp
            <div class="col-xl-3 col-md-4 col-sm-6 test-card-item" data-status="{{ $test->status }}" data-name="{{ strtolower($test->name) }}" data-category="{{ strtolower($cat) }}">
                <div class="card border-0 h-100 shadow-sm" style="border-radius: 20px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden;">
                    <!-- Category Header Strip -->
                    <div style="height: 4px; background: {{ $style['text'] }};"></div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: {{ $style['bg'] }}; border: 1px solid {{ $style['border'] }};">
                                <i class="fa-solid {{ $style['icon'] }}" style="color: {{ $style['text'] }}; font-size: 1.2rem;"></i>
                            </div>
                            <span class="badge rounded-pill px-3 py-1 small fw-semibold {{ $test->status === 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                {{ ucfirst($test->status) }}
                            </span>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: #1e293b; font-size: 1rem;">{{ $test->name }}</h5>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge rounded-pill px-2 py-1 small" style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; border: 1px solid {{ $style['border'] }};">
                                <i class="fa-solid {{ $style['icon'] }} me-1 small"></i>{{ $cat }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center gap-1 text-muted small">
                                <i class="fa-solid {{ $sampleIcon }} text-primary"></i>
                                <span>{{ $test->sample_type ?? 'Blood' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1 text-muted small">
                                <i class="fa-solid fa-clock text-warning"></i>
                                <span>{{ $test->turnaround_time ?? '24 hrs' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px dashed #e2e8f0;">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Price</small>
                                <span class="fw-bold text-success">TZS {{ number_format($test->price ?? 0) }}</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-2" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow" style="border-radius: 12px;">
                                    <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-eye me-2 text-primary"></i>View Details</a></li>
                                    <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-pen me-2 text-warning"></i>Edit Test</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
                        <i class="fa-solid fa-vial fs-2 text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No tests in catalog</h5>
                    <p class="text-muted small">Add your first lab test to get started</p>
                    <button class="btn btn-success rounded-3 px-4 mt-2" data-bs-toggle="modal" data-bs-target="#addTestModal">
                        <i class="fa-solid fa-plus me-2"></i>Add Test
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Test Modal -->
<div class="modal fade" id="addTestModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 text-white" style="background: linear-gradient(135deg, #0f4c3a 0%, #166534 50%, #15803d 100%);">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px;">
                        <i class="fa-solid fa-vial fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Add Lab Test</h5>
                        <small class="text-white text-opacity-75">Configure a new laboratory test</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Test Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-0 bg-light" style="border-radius: 12px;" placeholder="e.g. Complete Blood Count (CBC)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Category <span class="text-danger">*</span></label>
                        <select class="form-select border-0 bg-light" style="border-radius: 12px;">
                            <option>Hematology</option>
                            <option>Biochemistry</option>
                            <option>Microbiology</option>
                            <option>Serology</option>
                            <option>Urinalysis</option>
                            <option>Parasitology</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Type <span class="text-danger">*</span></label>
                        <select class="form-select border-0 bg-light" style="border-radius: 12px;">
                            <option>Blood</option>
                            <option>Urine</option>
                            <option>Stool</option>
                            <option>Sputum</option>
                            <option>Swab</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Price (TZS)</label>
                        <input type="number" class="form-control border-0 bg-light" style="border-radius: 12px;" placeholder="5000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Turnaround Time</label>
                        <input type="text" class="form-control border-0 bg-light" style="border-radius: 12px;" placeholder="e.g. 2 hours">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Normal Range / Reference</label>
                        <textarea class="form-control border-0 bg-light" rows="3" style="border-radius: 12px;" placeholder="Normal values and reference ranges..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light px-4 py-3">
                <button class="btn btn-light rounded-2 fw-semibold" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-2"></i>Cancel
                </button>
                <button class="btn btn-success rounded-2 px-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #059669, #10b981); border: none;">
                    <i class="fa-solid fa-save me-2"></i>Save Test
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .test-card-item .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .active-filter {
        background: #166534 !important;
        color: #fff !important;
        border-color: #166534 !important;
    }
</style>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('testSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.test-card-item').forEach(card => {
            const name = card.dataset.name;
            const category = card.dataset.category;
            card.style.display = (name.includes(query) || category.includes(query)) ? 'block' : 'none';
        });
    });

    // Filter buttons
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active-filter'));
            this.classList.add('active-filter');
            
            document.querySelectorAll('.test-card-item').forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    card.style.display = card.dataset.status === filter ? 'block' : 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
