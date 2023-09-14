import { createContext } from 'react';
import { Tank } from './types';

export const TankContext = createContext({
    tanks: []
} as { 
    tanks: Tank[] 
});