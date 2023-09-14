import { createContext } from 'react';
import { Power } from './types';

export const PowerContext = createContext({
    powers: []
} as { 
    powers: Power[] 
});