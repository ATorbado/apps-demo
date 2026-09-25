import Link from 'next/link';

export default function NotFound() {
  return (
    <main className="missing-guide" id="main-content">
      <div>
        <h1>This mark led nowhere.</h1>
        <p>The page may have moved, but the stain solver is still ready.</p>
        <Link className="primary-button" href="/">Return to ThreadCare Lab</Link>
      </div>
    </main>
  );
}
