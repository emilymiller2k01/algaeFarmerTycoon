export type Tank = {
    id: string
    farm_id: string
    nutrient_level: number
    co2_level: number
    biomass: number
    mw: number
}

export type Power = {
    type: PowerTypes,
    startup_cost: number, 
    ongoing_cost: number,
    mw: number,
}

export type PowerTypes = "solar" | "wind" | "gas"

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    }
}

export type User = {
    name: string
    email: string
    id: string
}
