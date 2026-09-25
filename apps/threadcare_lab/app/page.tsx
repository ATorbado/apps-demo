import StainSolver from './StainSolver';

const quickGuides = [
  {
    eyebrow: '3 minute rescue',
    motif: 'COFFEE',
    title: 'Coffee on a white tee',
    detail: 'Cold rinse first. Heat can make the mark harder to lift.',
    accent: 'coffee',
    slug: 'coffee-on-cotton',
  },
  {
    eyebrow: 'fabric-safe method',
    motif: 'OIL',
    title: 'Cooking oil on denim',
    detail: 'Blot, absorb, then pre-treat without spreading the stain.',
    accent: 'oil',
    slug: 'cooking-oil-on-denim',
  },
  {
    eyebrow: 'before it dries',
    motif: 'TOMATO',
    title: 'Tomato sauce on cotton',
    detail: 'Work from the back of the fabric and keep the water cool.',
    accent: 'tomato',
    slug: 'tomato-sauce-on-cotton',
  },
];

const fieldNotes = [
  ['01', 'Identify the fabric', 'Cotton, wool, silk and synthetics do not tolerate the same treatment.'],
  ['02', 'Check the care label', 'The garment maker’s instructions always outrank a viral cleaning hack.'],
  ['03', 'Start with the least force', 'Blot before rubbing, use cool water first and test an inside seam.'],
];

export default function Home() {
  return (
    <main id="main-content">
      <a className="skip-link" href="#solver">Skip to stain solver</a>
      <header className="site-header">
        <a className="brand" href="#top" aria-label="ThreadCare Lab home">
          <span className="brand-mark">T</span>
          <span>ThreadCare Lab</span>
        </a>
        <nav aria-label="Main navigation">
          <a href="#solver">Stain solver</a>
          <a href="#field-notes">Care basics</a>
          <a href="#guides">Guides</a>
        </nav>
        <a className="header-action" href="#solver">Solve a stain</a>
      </header>

      <section className="hero" id="top">
        <div className="hero-copy">
          <h1>Stop guessing<br />at the washer.</h1>
          <p className="hero-intro">
            Clear, fabric-aware answers for spills, care labels and laundry settings—before a small mistake becomes a permanent one.
          </p>
          <div className="hero-actions">
            <a className="primary-button" href="#solver">Find the safest first step</a>
            <a className="text-link" href="#guides">Browse quick guides</a>
          </div>
          <div className="safety-line" aria-label="Three essential fabric care rules">
            <span>Check the label</span>
            <span>Test a hidden area</span>
            <span>Never mix cleaners</span>
          </div>
        </div>

        <div className="hero-visual" aria-label="ThreadCare Lab field note: coffee on cotton">
          <div className="thread-line thread-one" />
          <div className="thread-line thread-two" />
          <article className="field-card">
            <div className="card-topline">
              <span>FIELD NOTE / 001</span>
              <span>2 MIN READ</span>
            </div>
            <div className="stain-swatch"><span /></div>
            <p className="specimen-label">COMMON SPILL · COTTON</p>
            <h2>Coffee, still fresh</h2>
            <p>Flush from the reverse with cool running water. Do not machine dry until the mark is gone.</p>
            <div className="temperature-row">
              <span>COOL WATER</span>
              <span className="temperature-bar"><i /></span>
              <strong>30°C MAX</strong>
            </div>
          </article>
          <div className="lab-note">LESS HEAT<br />MORE PATIENCE</div>
        </div>
      </section>

      <section className="solver-section" id="solver">
        <div>
          <h2>What happened?</h2>
          <p>Choose the mess and fabric. We’ll start with the lowest-risk action—not the loudest internet hack.</p>
        </div>
        <StainSolver />
      </section>

      <section className="guides-section" id="guides">
        <div className="section-heading">
          <div>
            <h2>Small emergencies,<br />calm instructions.</h2>
          </div>
          <p>Fast reads for the stains most likely to happen before breakfast, during dinner or five minutes before you leave.</p>
        </div>
        <div className="guide-grid">
          {quickGuides.map((guide, index) => (
            <a className={`guide-card guide-card-${index + 1}`} key={guide.title} href={`/guides/${guide.slug}`}>
              <div className={`guide-art ${guide.accent}`} aria-hidden="true"><span>{guide.motif}</span></div>
              <p>{guide.eyebrow}</p>
              <h3>{guide.title}</h3>
              <div className="guide-footer">
                <span>{guide.detail}</span>
                <b>Read guide</b>
              </div>
            </a>
          ))}
        </div>
      </section>

      <section className="principles" id="field-notes">
        <div className="principles-intro">
          <h2>Care before chemistry.</h2>
          <p>A reliable answer starts with the garment—not a miracle ingredient.</p>
        </div>
        <div className="principle-list">
          {fieldNotes.map(([number, title, detail]) => (
            <article key={number}>
              <span>{number}</span>
              <h3>{title}</h3>
              <p>{detail}</p>
            </article>
          ))}
        </div>
      </section>

      <footer>
        <a className="brand footer-brand" href="#top"><span className="brand-mark">T</span><span>ThreadCare Lab</span></a>
        <p>Better habits for clothes worth keeping.</p>
        <div className="footer-meta">
          <span>Independent fabric-care field notes · 2026</span>
          <nav aria-label="Legal and editorial information">
            <a href="/editorial-standards">Editorial standards</a>
            <a href="/privacy">Privacy</a>
          </nav>
        </div>
      </footer>
    </main>
  );
}
