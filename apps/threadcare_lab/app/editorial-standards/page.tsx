import type { Metadata } from 'next';
import Link from 'next/link';

export const metadata: Metadata = {
  title: 'Editorial standards — ThreadCare Lab',
  description: 'How ThreadCare Lab checks and presents fabric-care guidance.',
};

export default function EditorialStandardsPage() {
  return (
    <main className="article-page info-page" id="main-content">
      <a className="skip-link" href="#standards-content">Skip to editorial standards</a>
      <header className="site-header article-header">
        <Link className="brand" href="/" aria-label="ThreadCare Lab home"><span className="brand-mark">T</span><span>ThreadCare Lab</span></Link>
        <Link className="header-action" href="/">Return home</Link>
      </header>
      <article id="standards-content">
        <h1>Useful first. Careful always.</h1>
        <p className="article-deck">Every guide starts with the garment, the care label and the lowest-risk useful action.</p>
        <div className="info-sections">
          <section>
            <h2>Source hierarchy</h2>
            <p>Garment and product labels come first. Guidance is cross-checked against established fabric-care organizations and clearly linked when a source informs a guide.</p>
          </section>
          <section>
            <h2>Safety boundaries</h2>
            <p>Guides avoid unsafe cleaner combinations, recommend hidden-area testing and direct delicate, structured or dry-clean-only garments to professional care.</p>
          </section>
          <section>
            <h2>Corrections</h2>
            <p>Advice is revised when reliable evidence changes or a guide can be made clearer. ThreadCare Lab does not treat viral popularity as proof that a method is safe.</p>
          </section>
        </div>
        <p className="policy-note">These guides provide general fabric-care information. Always follow the garment and product labels for the item in front of you.</p>
      </article>
      <footer className="article-footer"><p>Better habits for clothes worth keeping.</p><Link href="/">ThreadCare Lab</Link></footer>
    </main>
  );
}
