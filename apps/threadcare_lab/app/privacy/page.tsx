import type { Metadata } from 'next';
import Link from 'next/link';

export const metadata: Metadata = {
  title: 'Privacy — ThreadCare Lab',
  description: 'How ThreadCare Lab handles information when you use this site.',
};

export default function PrivacyPage() {
  return (
    <main className="article-page info-page" id="main-content">
      <a className="skip-link" href="#policy-content">Skip to privacy information</a>
      <header className="site-header article-header">
        <Link className="brand" href="/" aria-label="ThreadCare Lab home"><span className="brand-mark">T</span><span>ThreadCare Lab</span></Link>
        <Link className="header-action" href="/">Return home</Link>
      </header>
      <article id="policy-content">
        <h1>Privacy, in plain language.</h1>
        <p className="article-deck">ThreadCare Lab currently works without accounts, comments, newsletters or advertising trackers.</p>
        <div className="info-sections">
          <section>
            <h2>What you provide</h2>
            <p>The stain solver runs in your browser. Your stain and fabric selections are not submitted through an account or saved as a personal profile by ThreadCare Lab.</p>
          </section>
          <section>
            <h2>Technical information</h2>
            <p>The hosting service may process standard technical information needed to deliver and protect the site, such as IP address, browser details and request logs.</p>
          </section>
          <section>
            <h2>If the site changes</h2>
            <p>This notice will be updated before adding analytics, advertising, forms or other features that change how information is handled.</p>
          </section>
        </div>
        <p className="policy-note">Current as of August 26, 2026. This page describes the site’s present behavior and is not legal advice.</p>
      </article>
      <footer className="article-footer"><p>Better habits for clothes worth keeping.</p><Link href="/">ThreadCare Lab</Link></footer>
    </main>
  );
}
