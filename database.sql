-- Create the players leaderboard table
CREATE TABLE IF NOT EXISTS public.players (
    username text NOT NULL,
    points integer DEFAULT 0 NOT NULL,
    region text DEFAULT 'NA'::text NOT NULL,
    vanilla text,
    uhc text,
    pot text,
    nethop text,
    smp text,
    sword text,
    axe text,
    mace text,
    created_at timestamp with time zone DEFAULT timezone('utc'::text, now()) NOT NULL,
    
    -- Set username as the primary unique identifier
    CONSTRAINT players_pkey PRIMARY KEY (username)
);

-- Enable Row Level Security (RLS)
ALTER TABLE public.players ENABLE ROW LEVEL SECURITY;

-- Create an All-Access Public Policy 
-- (Note: For public testing, this allows anonymous reads/writes via your API key)
CREATE POLICY "Public Anonymous Access" 
ON public.players 
FOR ALL 
USING (true) 
WITH CHECK (true);