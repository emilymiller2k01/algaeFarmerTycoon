import React, { useState, useEffect } from 'react';
import Tank, {TankProps} from './Tank';
import { GameProps } from '../Pages/Game';
import axios from "axios";
import {router, usePage} from "@inertiajs/react";
import {PageProps} from "@inertiajs/inertia";

type Tank = {
    id:number
    farm_id: string
    nutrient_level: number
    co2_level: number
    biomass: number
    mw: number
}
const TankContainer: React.FC<TankContainerProps> = ({ game, selectedFarmId }) => {

    const {tanks} = usePage<{tanks:Tank[]}>().props

    return (
        <div className="px-4 pb-4 pt-2 border-2 border-green-dark rounded-[10px] bg-transparent">
            <h1 className="text-2xl text-green font-semibold pb-2">
                Tanks - {tanks.length}/8 {/* Assuming you have a maximum of 10 tanks */}
            </h1>
            <div className="flex max-w-full flex-wrap gap-y-6 justify-evenly gap-x-4">
                {Array.isArray(tanks) && tanks.map(tank => (
                    <Tank key={tank.id} {...tank} />
                ))}
            </div>
        </div>
    );
};

type TankContainerProps = {
    game: GameProps;
    selectedFarmId: number;
};

export default TankContainer;
