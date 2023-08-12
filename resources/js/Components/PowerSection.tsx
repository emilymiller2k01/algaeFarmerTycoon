import React from 'react'
import GasSVG from "./Icons/GasSVG";
import PowerSVG from "./Icons/PowerSVG";
import SunSVG from "./Icons/SunSVG";
import WindSVG from "./Icons/WindSVG";
import {GameProps} from "../Pages/Game";

const PowerSection = ({ game, expanded = false, wind = 0, solar = 0, gas = 0 }: PowerSectionProps) => {

    return (
        <div className="p-4 flex border-2 border-green-dark rounded-[10px] gap-4 mr-auto">
            <div className="flex flex-col gap-4">
                <PowerSVG />
                <p className="text-green font-semibold text-2xl">
                    Power
                </p>
            </div>
            {(expanded) &&
                <>
                    <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                        <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Solar
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {solar}
                            </p>
                        </div>
                        <SunSVG className="mx-auto" />
                    </div>
                    <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                        <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Wind
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {wind}
                            </p>
                        </div>
                        <WindSVG className="mx-auto" />
                    </div>
                    <div className="flex flex-col gap-1 border px-3 py-1 border-green-dark rounded-lg w-[148px]">
                        <div className="flex w-full justify-between">
                            <p className="text-green font-semibold text-2xl">
                                Gas
                            </p>
                            <p className="text-green font-semibold text-2xl">
                                {gas}
                            </p>
                        </div>
                        <GasSVG className="mx-auto" />
                    </div>
                </>
            }

        </div>
    )
}

export default PowerSection;

export type PowerSectionProps = {
    game: GameProps,
    expanded?: boolean,
    wind?: number,
    solar?: number,
    gas?: number
}

