-- Create the main database layout structure
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
    
    CONSTRAINT players_pkey PRIMARY KEY (username)
);

-- Force row structure exposure to the public API
ALTER TABLE public.players ENABLE ROW LEVEL SECURITY;

-- Turn on unrestricted global read/write access policies
CREATE POLICY "Allow Public Read Access" ON public.players FOR SELECT USING (true);
CREATE POLICY "Allow Public Insert Access" ON public.players FOR INSERT WITH CHECK (true);
CREATE POLICY "Allow Public Update Access" ON public.players FOR UPDATE USING (true) WITH CHECK (true);
CREATE POLICY "Allow Public Delete Access" ON public.players FOR DELETE USING (true);