@extends('layout.template')
@section('content')

 <div class="page-content">
        <div class="container-fluid">

 <div class="card border-0 shadow-sm history-card mb-4">
      <div class="card-header bg-opacity-10 border-bottom border-primary border-opacity-25 bg-white py-3">
        <div class="d-flex align-items-center">
          <div class="section-header-icon">
            <i class="ri-history-line"></i>
          </div>
          <div class="ms-3">
            <h5 class="mb-0 fw-semibold text-primary">Barangay Ubaldo D. Laya · heritage & progress</h5>
            <small class="text-muted">From 1993 to present — a story of resilience and community</small>
          </div>
        </div>
      </div>
      

      <!-- =======  full narrative with css3 enhancements ====== -->
      <div class="card-body p-4">

        <!-- ORIGIN / FOUNDING block -->
        <div class="row mb-5">
          <div class="col-lg-8">
            <div class="d-flex gap-3 mb-3">
              <div class="section-header-icon">
                <i class="ri-leaf-line"></i>
              </div>
              <div>
                <h5 class="fw-semibold">Founding & the Laya family</h5>
                <p class="text-muted" style="text-align:justify">The barangay was named <strong>Ubaldo D. Laya</strong> because the Laya family donated the land on which it was established. The creation took place under Kapitan <strong>Reme Orbe</strong> in 1993, through <strong>City Ordinance No. 1946, series of 1991</strong>, and was approved in a plebiscite on <strong>July 25, 1993</strong>. Iligan City then increased from 43 to 44 barangays. The Laya family (notably Attorney Salvador Laya) donated land for the school, gymnasium, and subdivision roads – all documented with official donation papers.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="bg-light p-3 rounded-4 d-flex gap-3 align-items-center h-100">
              <i class="ri-government-line fs-1 text-primary opacity-50"></i>
              <div><span class="fw-bold text-primary">First IRA received:</span> 2023 <br> <small class="text-secondary">prior funding: LGU & national support</small></div>
            </div>
          </div>
        </div>

        <!-- TIMELINE administration cards (captains) -->
        <h5 class="fw-semibold mb-4"><i class="ri-user-star-line me-2 text-primary"></i>Legacy of leadership</h5>

        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-content w-100">
            <span class="chip-year"><i class="ri-calendar-line me-1"></i>1993 – 2001 (approx)</span>
            <h5 class="fw-semibold">Kapitan Remedios “Reme” Orbe</h5>
            <p class="mb-2"><span class="badge bg-primary bg-opacity-10 text-primary">appointed 1993 · elected 1994, re‑elected 1997</span></p>
            <p>First barangay captain. Under her watch: <strong>water system in Sitio Olas (₱400k)</strong> – ending scarcity. Barangay hall constructed with Congressman Badelles’ support (first three floors). Annual income then ₱1.4M + ₱500k from LGU.</p>
          </div>
        </div>

        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-content w-100">
            <span class="chip-year"><i class="ri-calendar-line me-1"></i>~2001 – 2013</span>
            <h5 class="fw-semibold">Kapitan Antonio Flores</h5>
            <p><strong>Key infra:</strong> concreting of Green Valley road (₱1.5M, Senator Lacson); 4‑inch water main (Green Valley); Greenville road to Purok 7 (₱2.5M, Varf Belmonte); drainage in Purok Silangan (Mayor Cruz). Gymnasium: posts ₱1M, bleachers & flooring ₱300k. Also negotiated riprap continuation.</p>
          </div>
        </div>

        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-content w-100">
            <span class="chip-year"><i class="ri-calendar-line me-1"></i>2013 – 2023</span>
            <h5 class="fw-semibold">Kapitan Inocencio G. Sailon</h5>
            <p>Re-elected after postponements (official term 2013–2023). <strong>Projects:</strong> multipurpose building (2022); road concreting Greenhills (₱2.5M), Purok Olas (₱2.5M), plus three other roads (₱3M, ₱2M, ₱2.5M). DOH project (₱1M), Kalahi‑CIDSS (₱2.5M, DSWD after Sendong).</p>
          </div>
        </div>

        <!-- Calamities & resilience -->
        <div class="row g-4 mt-2">
          <div class="col-md-6">
            <div class="bg-white p-4 rounded-4 border start border-3 border-warning border-opacity-25 h-100">
              <div class="d-flex gap-3 align-items-center mb-3">
                <span class="fs-1">🌊</span>
                <h5 class="fw-semibold mb-0">Typhoon Sendong (2011)</h5>
              </div>
              <p class="mb-1"><strong>Devastating flood</strong> – rivers from Pugaan & Tipanoy converge. Many livestock lost, houses near riverbanks swept. Evacuation at gym & school. Riprap project started but incomplete due to landowner refusal. Ongoing negotiations.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bg-white p-4 rounded-4 border start border-3 border-danger border-opacity-25 h-100">
              <div class="d-flex gap-3 align-items-center mb-3">
                <span class="fs-1">🔥</span>
                <h5 class="fw-semibold mb-0">Fire incidents</h5>
              </div>
              <p><strong>2010:</strong> Purok Silangan & Matinabangon (faulty wiring, 30 families) – limited aid because IRA not yet received. <strong>2019:</strong> Green Valley fire. Barangay responded with available funds.</p>
            </div>
          </div>
        </div>

        <!-- Population & Delicacy + challenges row -->
        <div class="row mt-5 align-items-stretch">
          <div class="col-lg-5 mb-4">
            <div class="bg-white p-4 rounded-4 border h-100">
              <div class="d-flex gap-2 mb-3">
                <i class="ri-group-line fs-2 text-primary"></i>
                <h5 class="fw-semibold">Population growth (PSA)</h5>
              </div>
              <div class="population-grid mb-3">
                <div class="year-pop-item"><span class="year">2003</span><div class="pop">8,043</div></div>
                <div class="year-pop-item"><span class="year">2004</span><div class="pop">8,118</div></div>
                <div class="year-pop-item"><span class="year">2005</span><div class="pop">8,194</div></div>
                <div class="year-pop-item"><span class="year">2006</span><div class="pop">8,270</div></div>
                <div class="year-pop-item"><span class="year">2007</span><div class="pop">8,347</div></div>
                <div class="year-pop-item"><span class="year">2008</span><div class="pop">8,424</div></div>
                <div class="year-pop-item"><span class="year">2009</span><div class="pop">8,503</div></div>
                <div class="year-pop-item"><span class="year">2010</span><div class="pop">8,582</div></div>
                <div class="year-pop-item"><span class="year">2011</span><div class="pop">8,662</div></div>
                <div class="year-pop-item"><span class="year">2015</span><div class="pop">11,950</div></div>
                <div class="year-pop-item"><span class="year">2024</span><div class="pop">13,626</div></div>
              </div>
              <div class="mt-3 text-muted fst-italic small">*2024 estimate: 13,626 residents</div>
            </div>
          </div>
          <div class="col-lg-7 mb-4">
            <div class="bg-white p-4 rounded-4 border h-100 d-flex flex-column">
              <div class="d-flex gap-3 align-items-center mb-3">
                <i class="ri-cup-line fs-2 text-warning"></i>
                <h5 class="fw-semibold mb-0">Local delicacy: Sukang Cardo</h5>
              </div>
              <p>A distinct vinegar blend, <span class="delicacy-badge"><i class="ri-spoon-line"></i> Sukang Cardo</span> — beloved as sawsawan. Compared to sukang pinakurat, but with unique local spices. Popular among Iliganons paired with grilled dishes.</p>
              <hr class="my-3">
              <h6 class="fw-semibold"><i class="ri-delete-bin-line me-2 text-secondary"></i>Current challenges</h6>
              <ul class="ps-3">
                <li><strong>Garbage:</strong> since MRF Bonbonon closure, temporary adjustments; committee proactive.</li>
                <li><strong>Diversion road:</strong> negotiated with landowners; deed donation delay due to inheritance tax (one landowner deceased). Road aims to connect river control area to 542, easing access to hospital & city hall.</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- additional details: financial & IRA note -->
        <div class="row mt-2 g-3">
          <div class="col-sm-6 col-lg-3">
            <div class="border rounded-4 p-3 text-center bg-light bg-opacity-30">
              <span class="stat-number">₱1.4M</span>
              <div class="stat-label">annual income (Orbe era)</div>
              <small class="text-secondary">+ LGU augmentation</small>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="border rounded-4 p-3 text-center bg-light bg-opacity-30">
              <span class="stat-number">17</span>
              <div class="stat-label">original puroks</div>
              <small>founding community</small>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="border rounded-4 p-3 text-center bg-light bg-opacity-30">
              <span class="stat-number">2023</span>
              <div class="stat-label">first IRA year</div>
              <small>internal revenue allotment</small>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="border rounded-4 p-3 text-center bg-light bg-opacity-30">
              <span class="stat-number">₱2.5M</span>
              <div class="stat-label">Kalahi-CIDSS</div>
              <small>post-Sendong (DSWD)</small>
            </div>
          </div>
        </div>

        <!-- closing citation about Laya donations -->
        <div class="mt-5 p-4 bg-primary bg-opacity-10 rounded-4 d-flex gap-3 align-items-center flex-wrap">
          <i class="ri-file-copy-line fs-1 text-primary"></i>
          <p class="mb-0 flex-fill"><em>“All donations (school, gym, subdivision lots 1–6) were formally documented, not merely verbal. The Laya family’s generosity shaped the barangay’s infrastructure.”</em> — including tax reduction arrangements.</p>
        </div>

        <!-- end of card body -->
      </div>
      <div class="card-footer bg-white border-0 pt-0 pb-3 text-muted small">
        <i class="ri-information-line"></i> Sources: PSA, Barangay records, interviews with Kapitan Flores & historical documents.
      </div>
    </div>





    </div>
                <!-- container-fluid -->
</div>


@endsection