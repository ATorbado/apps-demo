import type { Metadata } from 'next';
import Link from 'next/link';
import { notFound } from 'next/navigation';

type Guide = {
  title: string;
  deck: string;
  stain: string;
  fabric: string;
  time: string;
  steps: string[];
  avoid: string[];
  note: string;
};

const guides: Record<string, Guide> = {
  'coffee-on-cotton': {
    title: 'How to remove fresh coffee from cotton',
    deck: 'A calm, low-risk sequence for the spill that usually happens when you are already late.',
    stain: 'Coffee', fabric: 'Washable cotton', time: '10–20 minutes',
    steps: [
      'Blot excess coffee with a clean white cloth. Press—do not scrub.',
      'Turn the garment inside out and flush the back of the mark with cool running water.',
      'Apply a small amount of liquid laundry detergent and work it in gently with your fingers.',
      'Wash using the warmest setting permitted by the garment care label.',
      'Air-dry and inspect. Repeat the treatment if a shadow remains.',
    ],
    avoid: ['Tumble drying before the stain is gone', 'Aggressive rubbing', 'Using bleach without checking the care label'],
    note: 'Older coffee marks may need an enzyme-containing pre-treatment before laundering.',
  },
  'cooking-oil-on-denim': {
    title: 'How to remove cooking oil from denim',
    deck: 'Oil needs absorption and detergent—not a rush of water that spreads it through the weave.',
    stain: 'Cooking oil', fabric: 'Colorfast denim', time: '30–45 minutes',
    steps: [
      'Lift any food solids, then blot excess oil with a clean paper towel.',
      'Cover the mark with an absorbent powder and leave it in place for 15 minutes.',
      'Brush the powder away without grinding it into the fabric.',
      'Apply liquid laundry detergent to the spot and let it sit briefly.',
      'Wash the jeans inside out on the warmest setting allowed by the label, then air-dry to inspect.',
    ],
    avoid: ['Adding heat before the oil is removed', 'Scrubbing the dyed surface', 'Putting a visible mark in the dryer'],
    note: 'Heavy or old grease marks can require more than one pre-treatment cycle.',
  },
  'tomato-sauce-on-cotton': {
    title: 'How to remove tomato sauce from cotton',
    deck: 'Work from the reverse, keep the first rinse cool and stop the red pigment traveling deeper.',
    stain: 'Tomato sauce', fabric: 'Washable cotton', time: '15–30 minutes',
    steps: [
      'Lift away excess sauce with a spoon or dull edge. Do not smear it.',
      'Run cool water through the back of the stain as soon as possible.',
      'Work liquid laundry detergent gently from the outside edge toward the center.',
      'Rinse, apply a fabric-safe prewash stain remover and follow its label directions.',
      'Launder according to the garment label and air-dry until you know the stain is gone.',
    ],
    avoid: ['Rinsing through the front of the stain', 'Hot drying', 'Using a bleaching product without testing colorfastness'],
    note: 'A dried tomato stain may need the same process repeated before it clears.',
  },
};

export function generateStaticParams() {
  return Object.keys(guides).map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: { params: Promise<{ slug: string }> }): Promise<Metadata> {
  const { slug } = await params;
  const guide = guides[slug];
  if (!guide) return { title: 'Guide not found — ThreadCare Lab' };
  return {
    title: `${guide.title} — ThreadCare Lab`,
    description: guide.deck,
    openGraph: { title: guide.title, description: guide.deck, images: [] },
    twitter: { title: guide.title, description: guide.deck, images: [] },
  };
}

export default async function GuidePage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const guide = guides[slug];

  if (!guide) {
    notFound();
  }

  return (
    <main className="article-page" id="main-content">
      <a className="skip-link" href="#guide-content">Skip to guide</a>
      <header className="site-header article-header">
        <Link className="brand" href="/" aria-label="ThreadCare Lab home"><span className="brand-mark">T</span><span>ThreadCare Lab</span></Link>
        <Link className="header-action" href="/#solver">Open stain solver</Link>
      </header>
      <article id="guide-content">
        <Link className="article-back" href="/">All field notes</Link>
        <h1>{guide.title}</h1>
        <p className="article-deck">{guide.deck}</p>
        <div className="article-facts">
          <div><span>STAIN</span><b>{guide.stain}</b></div>
          <div><span>FABRIC</span><b>{guide.fabric}</b></div>
          <div><span>WORKING TIME</span><b>{guide.time}</b></div>
        </div>
        <section className="article-body">
          <div>
            <h2 className="section-title">Safe sequence</h2>
            <ol>{guide.steps.map((step) => <li key={step}>{step}</li>)}</ol>
          </div>
          <aside>
            <h2 className="section-title">Avoid</h2>
            <ul>{guide.avoid.map((item) => <li key={item}>{item}</li>)}</ul>
            <div className="article-note"><span>LAB NOTE</span><p>{guide.note}</p></div>
          </aside>
        </section>
        <section className="source-box">
          <h2 className="section-title">How this was checked</h2>
          <p>This guide follows garment-label-first principles and was cross-checked against the American Cleaning Institute’s stain guidance. Always test products on a hidden area and follow their labels.</p>
          <a href="https://www.cleaninginstitute.org/cleaning-tips/clothes/stain-removal-guide" target="_blank" rel="noreferrer">Open ACI reference</a>
        </section>
      </article>
      <footer className="article-footer">
        <p>Better habits for clothes worth keeping.</p>
        <nav aria-label="Guide footer navigation"><Link href="/editorial-standards">Editorial standards</Link><Link href="/privacy">Privacy</Link><Link href="/">ThreadCare Lab</Link></nav>
      </footer>
    </main>
  );
}
