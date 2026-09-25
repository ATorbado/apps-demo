import type { Metadata, Viewport } from 'next';
import './globals.css';

export const metadata: Metadata = {
  metadataBase: new URL(
    process.env.NEXT_PUBLIC_SITE_URL ?? 'http://localhost:3000',
  ),
  title: 'ThreadCare Lab — Fabric care without guesswork',
  description: 'Practical, fabric-aware guides for stains, care labels and laundry settings.',
  openGraph: {
    title: 'ThreadCare Lab — Fabric care without guesswork',
    description: 'Practical, fabric-aware guides for stains, care labels and laundry settings.',
    type: 'website',
    images: [
      {
        url: '/og.png',
        width: 1200,
        height: 630,
        alt: 'ThreadCare Lab — Fabric care without guesswork',
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: 'ThreadCare Lab — Fabric care without guesswork',
    description: 'Practical, fabric-aware guides for stains, care labels and laundry settings.',
    images: ['/og.png'],
  },
};

export const viewport: Viewport = {
  themeColor: '#f5f2e9',
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
