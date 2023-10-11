import { router, usePage } from '@inertiajs/react';
import React, { useEffect, useRef } from 'react';
import { HomeProps } from '../Pages/Game';

const LogSection = () => {
  const { messageLog, initialGame } = usePage<HomeProps>().props;
  const messagesEndRef = useRef(null);
  const containerRef = useRef(null);

  // Reverse the order of messages to display new messages at the top
  const reversedMessages = [...messageLog].reverse();

  // Scroll to the top when component mounts or when new messages are added
  useEffect(() => {
    scrollToTop();
  }, [reversedMessages]);

  const scrollToTop = () => {
    containerRef.current.scrollTop = 0;
  };

  const handleClearClick = async () => {
    try {
      // Send a POST request to clear the message log
      router.post(`/game/${initialGame.id}/clearMessageLog`);
      // Optionally, you can fetch the updated message log after clearing
      // and update the state to reflect the changes
      // ...

    } catch (error) {
      console.error("Failed to clear the message log", error);
    }
  };

  return (
    <div className="flex flex-col h-full overflow-hidden">
      <div className="flex px-8 py-6 bg-grey justify-between font-semibold">
        <h1 className="text-2xl text-green">Message Log</h1>
        {/* <h2 className="text-2xl text-green-dark" onClick={handleClearClick}>
          Clear
        </h2> */}
      </div>
      <div
        ref={containerRef}
        className="flex flex-col px-8 py-6 gap-2 flex-grow overflow-y-auto"
      >
        {reversedMessages.map((log, index) => (
          <p key={index} className="text-base text-green-dark text-left">
            {log.message}
          </p>
        ))}
        <div ref={messagesEndRef} />
      </div>
    </div>
  );
};

export default LogSection;

export type LogProps = {
  logs: string[];
};
