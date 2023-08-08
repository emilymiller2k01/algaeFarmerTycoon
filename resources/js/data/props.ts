import { InfoBoxProps } from "../Components/InfoBox";
import { LogProps } from "../Components/LogSection";
import { ProductionProps } from "../Components/ProductionSection";

export const production: ProductionProps = {
    powerOutput: "MW 3",
    moneyAmount: "35/1000",
    moneyRate: "6.2/s",
    algaeAmount: "35/100",
    algaeRate: "0.7Kg/s",
    tanks: "21/30",
    farms: "3/4",
    nutrientsAmount: "35/100",
    nutrientsRate: "-0.34/s",
    co2Amount: "5/100",
    co2Rate: "-0.24/s",
    temperature: "20°C",
    light: "40 Lux",
};

export const logs: LogProps = {
    logs: [
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
        "Something just happened",
    ],
}

export const research: InfoBoxProps[] = [
    {
        title: "Automated Harvesting",
        description: "Contiually harvest algae",
    },
    {
        title: "Automated Refining",
        description: "Contiually refine algae to produce bi-products",
    },
    {
        title: "Vertical Farming",
        description: "Double the amount of tanks a farm can store by stacking tanks vertically",
    },
    {
        title: "Renewable Energy",
        description: "Learn how to utilise renewable enrgy resources in your farm",
    },
    {
        title: "Automated Harvesting",
        description: "Contiually harvest algae",
    },
    {
        title: "Automated Refining",
        description: "Contiually refine algae to produce bi-products",
    },
    {
        title: "Vertical Farming",
        description: "Double the amount of tanks a farm can store by stacking tanks vertically",
    },
    {
        title: "Renewable Energy",
        description: "Learn how to utilise renewable enrgy resources in your farm",
    },
    
];

export const achievements: InfoBoxProps[] = [
    {
        title: "Launch Day",
        description: "Idled a farm",
    },
    {
        title: "Harvesting",
        description: "Automated harvesting",
    },
];