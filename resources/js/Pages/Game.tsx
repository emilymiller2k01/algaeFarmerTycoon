import React from 'react'
import '../../css/app.css'
import ExpansionsSection from '../components/ExpansionsSection'
import FarmsSection from '../components/FarmsSection'
import LogSection from '../components/LogSection'
import MultiSection from '../components/MultiSection'
import ProductionSection from '../components/ProductionSection'
import { logs, production } from '../data/props'

export default function Home() {
  return (
    <main className="flex min-h-screen max-h-screen min-w-full overflow-hidden max-w-full bg-grey-dark">
      <div className="flex w-full min-h-full">
        <div className="flex flex-col w-1/4 h-full">
          <div className="h-[60vh]">
            <ProductionSection {...production} />
          </div>
          <div className="h-[40vh]">
            <ExpansionsSection />
          </div>
        </div>
        <div className="flex flex-col w-1/2 h-full border-x-2 border-x-green">
          <MultiSection />
        </div>
        <div className="flex flex-col w-1/4 h-full">
          <div className="h-[45vh]">
            <FarmsSection />
          </div>
          <div className="h-[55vh]">
            <LogSection {...logs} />
          </div>
        </div>
      </div>
    </main>
  )
};
