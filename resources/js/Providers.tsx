import { PusherProvider } from "@harelpls/use-pusher";
import React from "react";
import { ComponentProps, ReactNode } from "react";

// Initialize websockets
const config = {
    clientKey: "client-key",
    cluster: "ap4",

    triggerEndpoint: "/pusher/trigger",

    authEndpoint: "/pusher/auth",
    auth: {
        headers: {Authorization: "Bearer token"},
    },
} satisfies ComponentProps<typeof PusherProvider>

function Providers({ children }: ProvidersProps) {
    return (
        <PusherProvider {...config}>
            {children}
        </PusherProvider>
    );
}

type ProvidersProps = {
    children?: ReactNode;
}

export default Providers;