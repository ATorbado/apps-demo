'use client';

import { useState } from 'react';

const treatments: Record<string, Record<string, { first: string; avoid: string }>> = {
  Coffee: {
    Cotton: { first: 'Flush from the back with cool running water, then apply a small amount of liquid laundry detergent.', avoid: 'Do not tumble dry until the mark has disappeared.' },
    Denim: { first: 'Blot, rinse from the reverse with cool water and wash inside out on the care-label setting.', avoid: 'Avoid scrubbing the dyed surface.' },
    Polyester: { first: 'Blot, rinse cool and pre-treat briefly with liquid detergent before washing.', avoid: 'Avoid high heat, which can set the stain.' },
    Wool: { first: 'Blot gently and follow the garment label. If washable, use cool water and wool-safe detergent.', avoid: 'Do not rub, wring or change water temperature suddenly.' },
  },
  'Cooking oil': {
    Cotton: { first: 'Blot excess oil, cover with an absorbent powder, brush away, then pre-treat with liquid detergent.', avoid: 'Do not add water before absorbing the excess oil.' },
    Denim: { first: 'Blot, absorb with cornstarch or baking soda, then apply liquid detergent and wash inside out.', avoid: 'Do not machine dry while a shadow remains.' },
    Polyester: { first: 'Blot well and work a drop of grease-cutting liquid detergent into the spot before washing.', avoid: 'Do not iron or expose the area to heat.' },
    Wool: { first: 'Blot without pressure and take structured or dry-clean-only wool to a professional cleaner.', avoid: 'Do not use alkaline powders or rub the fibers.' },
  },
  'Tomato sauce': {
    Cotton: { first: 'Lift solids, rinse from the back with cool water and pre-treat with liquid detergent.', avoid: 'Do not use hot water first.' },
    Denim: { first: 'Remove solids, rinse from the reverse and wash inside out according to the label.', avoid: 'Avoid chlorine bleach on colored denim.' },
    Polyester: { first: 'Rinse cool, pre-treat lightly and wash before the stain dries.', avoid: 'Do not tumble dry until fully clear.' },
    Wool: { first: 'Lift solids with a spoon, blot and consult the care label or a professional cleaner.', avoid: 'Do not scrub or soak structured wool.' },
  },
  'Red wine': {
    Cotton: { first: 'Blot immediately, flush from the back with cool water and pre-treat before washing.', avoid: 'Do not rub or apply heat.' },
    Denim: { first: 'Blot, rinse from the reverse and use color-safe detergent on the care-label cycle.', avoid: 'Avoid chlorine bleach and hot drying.' },
    Polyester: { first: 'Blot, rinse cool and pre-treat with liquid detergent as soon as possible.', avoid: 'Do not let the garment sit in a hot car or dryer.' },
    Wool: { first: 'Blot with a white cloth and contact a cleaner for dry-clean-only or structured garments.', avoid: 'Do not use salt as an abrasive or scrub.' },
  },
};

export default function StainSolver() {
  const [stain, setStain] = useState('Coffee');
  const [fabric, setFabric] = useState('Cotton');
  const [showResult, setShowResult] = useState(false);
  const result = treatments[stain][fabric];

  return (
    <div className="solver-shell">
      <form className="solver-form" onSubmit={(event) => { event.preventDefault(); setShowResult(true); }}>
        <label>
          <span>STAIN</span>
          <select name="stain" autoComplete="off" value={stain} onChange={(event) => { setStain(event.target.value); setShowResult(false); }}>
            {Object.keys(treatments).map((value) => <option key={value}>{value}</option>)}
          </select>
        </label>
        <label>
          <span>FABRIC</span>
          <select name="fabric" autoComplete="off" value={fabric} onChange={(event) => { setFabric(event.target.value); setShowResult(false); }}>
            {Object.keys(treatments.Coffee).map((value) => <option key={value}>{value}</option>)}
          </select>
        </label>
        <button type="submit">Get first steps</button>
      </form>
      {showResult && (
        <aside className="solver-result" aria-live="polite" role="status">
          <div><span>DO THIS FIRST</span><p>{result.first}</p></div>
          <div><span>AVOID</span><p>{result.avoid}</p></div>
          <button type="button" onClick={() => setShowResult(false)}>Close</button>
        </aside>
      )}
    </div>
  );
}
