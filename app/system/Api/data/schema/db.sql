PRAGMA foreign_keys = on;

-- Keeps subscription device & access data.
CREATE TABLE IF NOT EXISTS "subscription" (
    "id"            INTEGER         PRIMARY KEY AUTOINCREMENT NOT NULL,
    "device_uuid"   VARCHAR(32)     NOT NULL,
    "device_name"   VARCHAR(50)     NOT NULL,
    "access_token"  VARCHAR(255)    NOT NULL,
    "status"        VARCHAR(50)     NOT NULL,
    "credit"        INTEGER         NOT NULL,
    "created_at"    DATETIME        NOT NULL,
    "updated_at"    DATETIME
);

-- Keeps chat data.
CREATE TABLE IF NOT EXISTS "chat" (
    "id"            INTEGER         PRIMARY KEY AUTOINCREMENT NOT NULL,
    "pid"           INTEGER         REFERENCES "chat" ("id"), -- Parent ID.
    "sid"           INTEGER         REFERENCES "subscription" ("id") NOT NULL, -- Subscription ID.
    "message"       TEXT            NOT NULL,
    "response"      TEXT            NOT NULL,
    "created_at"    DATETIME        NOT NULL,
    "updated_at"    DATETIME

    -- FOREIGN KEY ("pid") REFERENCES "chat" ("id")
    -- FOREIGN KEY ("sid") REFERENCES "subscription" ("id")
);
