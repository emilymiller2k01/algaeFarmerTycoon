export type Tank = {
    farm_id: string
    nutrient_level: number
    co2_level: number
    biomass: number
    mw: number
}

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
