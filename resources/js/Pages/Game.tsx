import React from 'react';
import '../../css/app.css';
import ExpansionsSection from '../Components/ExpansionsSection';
import FarmsSection from '../Components/FarmsSection';
import LogSection from '../Components/LogSection';
import MultiSection from '../Components/MultiSection';
import ProductionSection from '../Components/ProductionSection';
import { logs, production } from '../data/props';

export type GameProps = {
    id: number;
    name: string;
    user_id: number;
    mw: number;
    money: number;
    mw_cost: number;
    selected_farm_id: number;
}

type HomeProps = {
    game: GameProps;
}

const Home: React.FC<HomeProps> = ({ game }) => {
    return (
        <main className="flex min-h-screen max-h-screen min-w-full overflow-hidden max-w-full bg-grey-dark">
            <div className="flex w-full min-h-full">
                <div className="flex flex-col w-1/4 h-full">
                    <div className="h-[60vh]">
                        <ProductionSection game={game} {...production} />
                    </div>
                    <div className="h-[40vh]">
                        <ExpansionsSection game={game} />
                    </div>
                </div>
                <div className="flex flex-col w-1/2 h-full border-x-2 border-x-green">
                    <MultiSection game={game} />
                </div>
                <div className="flex flex-col w-1/4 h-full">
                    <div className="h-[45vh]">
                        <FarmsSection game={game} />
                    </div>
                    <div className="h-[55vh]">
                        <LogSection {...logs} />
                    </div>
                </div>
            </div>
        </main>
    )
};

export default Home;
